"use client";
import React, { useState, useEffect, useCallback } from "react";
import Link from "next/link";
import { productsAPI, categoriesAPI, brandsAPI } from "../../src/services/api";
import { cartStorage } from "../../src/utils/cartStorage";
import ProductCard from "../components/ProductCard";
import "../Shop/Shop.css";

const ShopPage = ({ updateCartCount }: { updateCartCount?: (count?: number) => void }) => {
  const [products, setProducts] = useState<any[]>([]);
  const [categories, setCategories] = useState<any[]>([]);
  const [brands, setBrands] = useState<any[]>([]);
  const [loading, setLoading] = useState(true);
  const [loadingMore, setLoadingMore] = useState(false);
  const [addingToCart, setAddingToCart] = useState<{ [key: string]: boolean }>({});
  const [showToast, setShowToast] = useState(false);
  const [toastMessage, setToastMessage] = useState("");
  const [showAllCategories, setShowAllCategories] = useState(false);
  const [showAllBrands, setShowAllBrands] = useState(false);
  // Filters
  const [priceRange, setPriceRange] = useState<[number, number]>([0, 19500]);
  const [selectedCategories, setSelectedCategories] = useState<number[]>([]);
  const [selectedBrands, setSelectedBrands] = useState<number[]>([]);
  const [sortBy, setSortBy] = useState("default");
  const [searchQuery, setSearchQuery] = useState("");
  // Pagination
  const [currentPage, setCurrentPage] = useState(1);
  const [totalPages, setTotalPages] = useState(1);
  const [perPage] = useState(12);

  useEffect(() => {
    // Load categories and brands with caching
    const loadFilters = async () => {
      try {
        const cachedCategories = typeof window !== "undefined" ? localStorage.getItem("categories_cache") : null;
        const cachedBrands = typeof window !== "undefined" ? localStorage.getItem("brands_cache") : null;
        const cacheTime = typeof window !== "undefined" ? localStorage.getItem("categories_cache_time") : null;
        const now = Date.now();
        if (cachedCategories && cacheTime && now - parseInt(cacheTime) < 300000) {
          setCategories(JSON.parse(cachedCategories));
          if (cachedBrands) {
            setBrands(JSON.parse(cachedBrands));
          }
          return;
        }
        const [categoriesResponse, brandsResponse] = await Promise.all([
          categoriesAPI.getAll(),
          brandsAPI.getAll(),
        ]);
        const categoriesData = categoriesResponse.data?.data || categoriesResponse.data || categoriesResponse;
        if (Array.isArray(categoriesData)) {
          setCategories(categoriesData);
          if (typeof window !== "undefined") {
            localStorage.setItem("categories_cache", JSON.stringify(categoriesData));
            localStorage.setItem("categories_cache_time", now.toString());
          }
        }
        const brandsData = brandsResponse.data?.data || brandsResponse.data || brandsResponse;
        if (Array.isArray(brandsData)) {
          setBrands(brandsData);
          if (typeof window !== "undefined") {
            localStorage.setItem("brands_cache", JSON.stringify(brandsData));
          }
        }
      } catch (error) {
        // handle error
      }
    };
    loadFilters();
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, []);

  const fetchProducts = useCallback(async (page: number) => {
    if (page > totalPages) return;
    try {
      setLoadingMore(true);
      const params: any = {
        page: page,
        per_page: perPage,
        min_price: priceRange[0],
        max_price: priceRange[1],
      };
      if (selectedCategories.length > 0) {
        params.categories = selectedCategories.join(",");
      }
      if (selectedBrands.length > 0) {
        params.brands = selectedBrands.join(",");
      }
      if (sortBy !== "default") {
        params.sort = sortBy;
      }
      if (searchQuery) {
        params.search = searchQuery;
      }
      const response = await productsAPI.getAll(currentPage, perPage, params);
      const productsData = response.data?.data || response.data || response;
      if (Array.isArray(productsData)) {
        setProducts((prev) => [...prev, ...productsData]);
        setTotalPages(response.data?.last_page || 1);
      } else if (productsData.data && Array.isArray(productsData.data)) {
        setProducts(productsData.data);
        setTotalPages(productsData.last_page || 1);
      } else {
        setProducts([]);
      }
    } catch (error) {
      setProducts([]);
    } finally {
      setLoading(false);
      setLoadingMore(false);
    }
  }, [totalPages, priceRange, selectedCategories, selectedBrands, sortBy, searchQuery, perPage, currentPage]);

  useEffect(() => {
    fetchProducts(currentPage);
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [currentPage, priceRange, selectedCategories, selectedBrands, sortBy, searchQuery, fetchProducts]);

  const handleCategoryToggle = (categoryId: number) => {
    setSelectedCategories((prev) =>
      prev.includes(categoryId) ? prev.filter((id) => id !== categoryId) : [...prev, categoryId]
    );
    setCurrentPage(1);
  };

  const handleBrandToggle = (brandId: number) => {
    setSelectedBrands((prev) =>
      prev.includes(brandId) ? prev.filter((id) => id !== brandId) : [...prev, brandId]
    );
    setCurrentPage(1);
  };

  const handlePriceChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const value = parseInt(e.target.value);
    setPriceRange([0, value]);
    setCurrentPage(1);
  };

  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault();
    setCurrentPage(1);
    fetchProducts(currentPage);
  };

  const handleAddToCart = async (productId: number, e?: any) => {
    if (e) {
      e.preventDefault();
      e.stopPropagation();
    }
    setAddingToCart((prev) => ({ ...prev, [productId]: true }));
    try {
      const product = products.find((p) => p.id === productId);
      if (!product) throw new Error("Product not found");
      cartStorage.addItem(product, 1);
      if (updateCartCount) {
        const cart = cartStorage.getCart();
        updateCartCount(cart.count);
      }
      setToastMessage("✓ Product added to cart!");
      setShowToast(true);
      setTimeout(() => setShowToast(false), 3000);
    } catch (error) {
      setToastMessage("✗ Failed to add to cart");
      setShowToast(true);
      setTimeout(() => setShowToast(false), 3000);
    } finally {
      setAddingToCart((prev) => ({ ...prev, [productId]: false }));
    }
  };

  const handleScroll = useCallback(() => {
    if (loadingMore || currentPage >= totalPages) return;
    const { scrollTop, scrollHeight, clientHeight } = document.documentElement;
    if (scrollHeight - scrollTop <= clientHeight + 100) {
      setCurrentPage((prev) => prev + 1);
    }
  }, [loadingMore, currentPage, totalPages]);

  useEffect(() => {
    window.addEventListener("scroll", handleScroll);
    return () => window.removeEventListener("scroll", handleScroll);
  }, [handleScroll]);

  return (
    <div className="shop-page">
      {/* Toast Notification */}
      {showToast && <div className="toast-notification">{toastMessage}</div>}
      <div className="shop-container">
        {/* Sidebar */}
        <aside className="shop-sidebar">
          {/* Price Filter */}
          <div className="filter-section">
            <h3>Filter by Price</h3>
            <div className="price-range">
              <input type="range" min="0" max="19500" value={priceRange[1]} onChange={handlePriceChange} className="price-slider" />
              <div className="price-labels">
                <span>৳ {priceRange[0]}</span>
                <span>৳ {priceRange[1]}</span>
              </div>
            </div>
          </div>
          {/* Categories Filter */}
          <div className="filter-section">
            <h3>Product Categories</h3>
            <div className="category-list">
              {(showAllCategories ? categories : categories.slice(0, 10)).map((category: any) => (
                <label key={category.id} className="filter-item">
                  <input type="checkbox" checked={selectedCategories.includes(category.id)} onChange={() => handleCategoryToggle(category.id)} />
                  <span className="category-name">{category.name}</span>
                  <span className="category-count">{category.products_count || 0}</span>
                </label>
              ))}
            </div>
            {categories.length > 10 && (
              <button className="see-more-btn" onClick={() => setShowAllCategories(!showAllCategories)}>
                {showAllCategories ? "See Less" : "See More"}
              </button>
            )}
          </div>
          {/* Brands Filter */}
          {brands.length > 0 && (
            <div className="filter-section">
              <h3>Brands</h3>
              <div className="brand-list">
                {(showAllBrands ? brands : brands.slice(0, 10)).map((brand: any) => (
                  <label key={brand.id} className="filter-item">
                    <input type="checkbox" checked={selectedBrands.includes(brand.id)} onChange={() => handleBrandToggle(brand.id)} />
                    <span className="brand-name">{brand.name || brand.admin_name}</span>
                  </label>
                ))}
              </div>
              {brands.length > 10 && (
                <button className="see-more-btn" onClick={() => setShowAllBrands(!showAllBrands)}>
                  {showAllBrands ? "See Less" : "See More"}
                </button>
              )}
            </div>
          )}
        </aside>
        {/* Main Content */}
        <main className="shop-main">
          {/* Search & Sort Bar */}
          <div className="shop-header">
            <form onSubmit={handleSearch} className="shop-search">
              <input type="text" placeholder="Search here..." value={searchQuery} onChange={(e) => setSearchQuery(e.target.value)} />
              <button type="submit">🔍</button>
            </form>
            <select className="sort-select" value={sortBy} onChange={(e) => setSortBy(e.target.value)}>
              <option value="default">Default sorting</option>
              <option value="price_low">Price: Low to High</option>
              <option value="price_high">Price: High to Low</option>
              <option value="name_asc">Name: A to Z</option>
              <option value="name_desc">Name: Z to A</option>
              <option value="newest">Newest First</option>
            </select>
          </div>
          {/* Products Grid */}
          {loading ? (
            <div className="loading">Loading products...</div>
          ) : products.length > 0 ? (
            <>
              <div className="products-grid">
                {products.map((product) => (
                  <ProductCard
                    key={product.id}
                    product={product}
                    onAddToCart={() => handleAddToCart(product.id)}
                    addingToCart={!!addingToCart[product.id]}
                  />
                ))}
              </div>
              {loadingMore && <div className="loading-more">Loading more products...</div>}
            </>
          ) : (
            <div className="no-products">No products found</div>
          )}
        </main>
      </div>
    </div>
  );
};

export default ShopPage;
