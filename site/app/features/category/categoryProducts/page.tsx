
"use client";
import React, { useState, useEffect } from "react";
import { useSearchParams, useRouter } from "next/navigation";
import ProductCard from "../../../components/ProductCard";
import { productsAPI, categoriesAPI, brandsAPI } from "../../../../frontend/src/services/api";
import { cartStorage } from "../../../utils/cartStorage";
import Link from "next/link";
import "./Shop.css";

const CategoryProductsPage = ({ params }: { params?: { slug?: string } }) => {
  // Next.js dynamic route: /CategoryProducts/[slug]
  const searchParams = useSearchParams();
  const router = useRouter();
  const slug = params?.slug || searchParams.get("slug") || "";

  const [products, setProducts] = useState<any[]>([]);
  const [category, setCategory] = useState<any>(null);
  const [categories, setCategories] = useState<any[]>([]);
  const [brands, setBrands] = useState<any[]>([]);
  const [loading, setLoading] = useState(false);
  const [initialLoading, setInitialLoading] = useState(true);
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
    // Load all data in parallel with caching
    const initializeData = async () => {
      setInitialLoading(true);
      try {
        // Check cache first
        const cachedCategories = typeof window !== "undefined" ? localStorage.getItem("categories_cache") : null;
        const cachedBrands = typeof window !== "undefined" ? localStorage.getItem("brands_cache") : null;
        const cacheTime = typeof window !== "undefined" ? localStorage.getItem("categories_cache_time") : null;
        const now = Date.now();
        // Use cache if less than 5 minutes old
        if (cachedCategories && cacheTime && now - parseInt(cacheTime) < 300000) {
          console.log('CACHED categories_cache:', cachedCategories);
          console.log('CACHED brands_cache:', cachedBrands);
          let categoriesData = [];
          try {
            categoriesData = cachedCategories ? JSON.parse(cachedCategories) : [];
          } catch (e) {
            categoriesData = [];
          }
          console.log('PARSED categoriesData:', categoriesData);
          setCategories(categoriesData);
          // Find current category from cache
          const foundCategory = categoriesData.find((cat: any) => cat.slug === slug || cat.id === parseInt(slug));
          console.log('FOUND category:', foundCategory);
          if (foundCategory) {
            setCategory(foundCategory);
            setSelectedCategories([foundCategory.id]);
          }
          // Set cached brands if available
          if (cachedBrands) {
            try {
              const parsedBrands = JSON.parse(cachedBrands);
              console.log('PARSED brands:', parsedBrands);
              setBrands(parsedBrands);
            } catch (e) {
              setBrands([]);
            }
          }
          setInitialLoading(false);
          return;
        }
        // Fetch categories, brands in parallel if no cache
        const [categoriesResponse, brandsResponse] = await Promise.all([
          categoriesAPI.getAll(),
          brandsAPI.getAll(),
        ]);
        // Set categories
        const categoriesData = categoriesResponse.data?.data || categoriesResponse.data || categoriesResponse;
        if (Array.isArray(categoriesData)) {
          setCategories(categoriesData);
          if (typeof window !== "undefined") {
            localStorage.setItem("categories_cache", JSON.stringify(categoriesData));
            localStorage.setItem("categories_cache_time", now.toString());
          }
          // Find current category
          const foundCategory = categoriesData.find((cat: any) => cat.slug === slug || cat.id === parseInt(slug));
          if (foundCategory) {
            setCategory(foundCategory);
            setSelectedCategories([foundCategory.id]);
          }
        }
        // Set brands
        const brandsData = brandsResponse.data?.data || brandsResponse.data || brandsResponse;
        if (Array.isArray(brandsData)) {
          setBrands(brandsData);
          if (typeof window !== "undefined") {
            localStorage.setItem("brands_cache", JSON.stringify(brandsData));
          }
        }
      } catch (error) {
        console.error("Error loading data:", error);
      } finally {
        setInitialLoading(false);
      }
    };
    initializeData();
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [slug]);

  useEffect(() => {
    if (selectedCategories.length > 0 && !initialLoading) {
      fetchProducts();
    }
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [currentPage, priceRange, selectedCategories, selectedBrands, sortBy, searchQuery]);

  const fetchProducts = async () => {
    setLoading(true);
    try {
      const params: any = {
        page: currentPage,
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
      console.log('API products response:', response);
      // Always map products from response.products.data (backend structure)
      const productsData = response.products?.data || [];
      setProducts(productsData);
      // Set pagination if available
      if (response.products?.last_page) {
        setTotalPages(response.products.last_page);
      }
    } catch (error) {
      console.error("Error fetching products:", error);
    } finally {
      setLoading(false);
    }
  };

  const handlePriceChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const value = parseInt(e.target.value);
    setPriceRange([0, value]);
    setCurrentPage(1);
  };

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

  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault();
    setCurrentPage(1);
  };

  const handleAddToCart = async (product: any) => {
    setAddingToCart((prev) => ({ ...prev, [product.id]: true }));
    try {
      cartStorage.addItem(product, 1);
      setToastMessage(`${product.name} added to cart!`);
      setShowToast(true);
      setTimeout(() => setShowToast(false), 3000);
    } catch (error) {
      console.error("Error adding to cart:", error);
    } finally {
      setAddingToCart((prev) => ({ ...prev, [product.id]: false }));
    }
  };

  if (!category) {
    return (
      <div className="shop-page">
        <div className="container" style={{ padding: "60px 20px", textAlign: "center" }}>
          <h2>Category not found</h2>
          <Link href="/shop" className="btn-primary" style={{ marginTop: "20px" }}>
            Back to Shop
          </Link>
        </div>
      </div>
    );
  }

  return (
    <div className="shop-page">
      {showToast && <div className="toast-notification">{toastMessage}</div>}
      <div className="shop-container">
        {/* Sidebar */}
        <aside className="shop-sidebar">
          {/* Price Filter */}
          <div className="filter-section">
            <h3>Filter by Price</h3>
            <div className="price-range">
              <input
                type="range"
                min="0"
                max="19500"
                value={priceRange[1]}
                onChange={handlePriceChange}
                className="price-slider"
              />
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
              {(showAllCategories ? categories : categories.slice(0, 10)).map((cat: any) => (
                <label key={cat.id} className="filter-item">
                  <input
                    type="checkbox"
                    checked={selectedCategories.includes(cat.id)}
                    onChange={() => handleCategoryToggle(cat.id)}
                  />
                  <span className="category-name">{cat.name}</span>
                  <span className="category-count">{cat.products_count || 0}</span>
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
                    <input
                      type="checkbox"
                      checked={selectedBrands.includes(brand.id)}
                      onChange={() => handleBrandToggle(brand.id)}
                    />
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
          {/* Breadcrumb */}
          <div className="breadcrumb" style={{ marginBottom: "20px", fontSize: "14px", color: "#666" }}>
            <Link href="/" style={{ color: "#ff1493" }}>Home</Link>
            <span> / </span>
            <Link href="/shop" style={{ color: "#ff1493" }}>Shop</Link>
            <span> / </span>
            <span>{category.name}</span>
          </div>
          {/* Page Title */}
          <h1 style={{ fontSize: "28px", fontWeight: 700, marginBottom: "20px", color: "#333" }}>{category.name}</h1>
          {/* Search & Sort Bar */}
          <div className="shop-header">
            <form onSubmit={handleSearch} className="shop-search">
              <input
                type="text"
                placeholder="Search here..."
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
              />
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
            <div className="loading-spinner">
              <div className="spinner"></div>
              <p>Loading products...</p>
            </div>
          ) : products.length === 0 ? (
            <div className="no-products">
              <p>No products found in this category.</p>
            </div>
          ) : (
            <>
              <div className="products-grid">
                {products.map((product) => (
                  <ProductCard
                    key={product.id}
                    product={product}
                    onAddToCart={handleAddToCart}
                    isAddingToCart={!!addingToCart[product.id]}
                  />
                ))}
              </div>
              {/* Pagination */}
              {totalPages > 1 && (
                <div className="pagination">
                  <button
                    className="pagination-btn"
                    onClick={() => setCurrentPage((prev) => Math.max(1, prev - 1))}
                    disabled={currentPage === 1}
                  >
                    Previous
                  </button>
                  <div className="pagination-numbers">
                    {Array.from({ length: totalPages }).map((_, index) => (
                      <button
                        key={index + 1}
                        className={`pagination-number ${currentPage === index + 1 ? "active" : ""}`}
                        onClick={() => setCurrentPage(index + 1)}
                      >
                        {index + 1}
                      </button>
                    ))}
                  </div>
                  <button
                    className="pagination-btn"
                    onClick={() => setCurrentPage((prev) => Math.min(totalPages, prev + 1))}
                    disabled={currentPage === totalPages}
                  >
                    Next
                  </button>
                </div>
              )}
            </>
          )}
        </main>
      </div>
    </div>
  );
};

export default CategoryProductsPage;
