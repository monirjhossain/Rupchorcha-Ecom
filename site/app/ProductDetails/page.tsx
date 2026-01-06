
"use client";
import React, { useState, useEffect } from "react";
import { useSearchParams } from "next/navigation";
import Link from "next/link";
import { productsAPI } from "../../src/services/api";
import { cartStorage } from "../../src/utils/cartStorage";
import { wishlistStorage } from "../../src/utils/wishlistStorage";
import Toast from "../components/Toast";
import "../ProductDetails/ProductDetails.css";

const ProductDetailsPage = ({ params }: { params?: { slug?: string } }) => {
  const searchParams = useSearchParams();
  const slug = params?.slug || searchParams.get("slug") || "";
  const [product, setProduct] = useState<any>(null);
  const [loading, setLoading] = useState(true);
  const [selectedImage, setSelectedImage] = useState(0);
  const [quantity, setQuantity] = useState(1);
  const [addingToCart, setAddingToCart] = useState(false);
  const [showToast, setShowToast] = useState(false);
  const [wishlistToast, setWishlistToast] = useState({ show: false, message: '', type: 'success' });
  const [isInWishlist, setIsInWishlist] = useState(false);

  useEffect(() => {
    fetchProduct();
    setIsInWishlist(wishlistStorage.isInWishlist(slug));
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [slug]);

  const handleWishlistClick = () => {
    if (!product) return;
    if (isInWishlist) {
      wishlistStorage.removeItem(product.id);
      setIsInWishlist(false);
      setWishlistToast({ show: true, message: 'Removed from wishlist', type: 'info' });
    } else {
      wishlistStorage.addItem(product);
      setIsInWishlist(true);
      setWishlistToast({ show: true, message: 'Added to wishlist', type: 'success' });
    }
    setTimeout(() => setWishlistToast({ show: false, message: '', type: 'success' }), 1800);
  };

  const fetchProduct = async () => {
    try {
      const response = await productsAPI.getBySlug(slug);
      const productData = response.data?.data || response.data || response;
      setProduct(productData);
    } catch (error) {
      setProduct(null);
    } finally {
      setLoading(false);
    }
  };

  const handleAddToCart = () => {
    setAddingToCart(true);
    try {
      const finalPrice = product.special_price || product.price;
      const cartItem = {
        id: product.id,
        name: product.name,
        price: finalPrice,
        image: product.images?.[0]?.url || '',
        quantity: quantity,
      };
      cartStorage.addItem(cartItem);
      setShowToast(true);
      setQuantity(1);
    } catch (error) {
      // handle error
    } finally {
      setAddingToCart(false);
    }
  };

  const calculateDiscount = () => {
    if (!product?.price || !product?.special_price) return 0;
    return Math.round(((product.price - product.special_price) / product.price) * 100);
  };

  if (loading) {
    return <div className="loading-container">Loading product...</div>;
  }
  if (!product) {
    return <div className="error-container">Product not found</div>;
  }
  const discount = calculateDiscount();
  const finalPrice = product.special_price || product.price;

  return (
    <div className="product-details-page">
      <div className="container">
        <div className="breadcrumb">
          <Link href="/">Home</Link> <span>/</span> <Link href="/shop">Shop</Link> <span>/</span> <span>{product.name}</span>
        </div>
        <div className="product-details-container">
          {/* Left: Images */}
          <div className="product-images">
            <div className="main-image">
              {discount > 0 && <span className="discount-badge">{discount}% OFF</span>}
              <img
                src={product.images?.[selectedImage]?.url || 'https://via.placeholder.com/500x500/f0f0f0/999?text=No+Image'}
                alt={product.name}
              />
              <button className="zoom-btn">🔍</button>
            </div>
            {product.images && product.images.length > 1 && (
              <div className="image-thumbnails">
                {product.images.map((image: any, index: number) => (
                  <img
                    key={index}
                    src={image.url}
                    alt={`${product.name} ${index + 1}`}
                    className={selectedImage === index ? 'active' : ''}
                    onClick={() => setSelectedImage(index)}
                  />
                ))}
              </div>
            )}
          </div>
          {/* Right: Product Info */}
          <div className="product-info">
            <h1 className="product-title">{product.name}</h1>
            <div className="product-rating">
              <div className="stars">
                {'⭐'.repeat(5)}
                <span className="rating-text">(6 Reviews)</span>
              </div>
            </div>
            <div className="product-price">
              <span className="current-price">৳ {finalPrice}</span>
              {product.special_price && <span className="original-price">৳ {product.price}</span>}
              {discount > 0 && <span className="save-amount">Save ৳{product.price - product.special_price}</span>}
            </div>
            <div className="product-badges">
              <span className="badge best-seller">No #1 Best Seller</span>
              <span className="badge category">in Monalisa</span>
              <span className="badge brand">{product.brand?.name || 'N/A'}</span>
            </div>
            {/* Quantity & Add to Cart */}
            <div className="add-to-cart-section">
              <div className="quantity-control">
                <label>Quantity:</label>
                <div className="quantity-selector">
                  <button onClick={() => setQuantity(Math.max(1, quantity - 1))} disabled={quantity <= 1} className="qty-btn">-</button>
                  <input type="number" value={quantity} onChange={(e) => setQuantity(Math.max(1, parseInt(e.target.value) || 1))} min="1" readOnly />
                  <button onClick={() => setQuantity(quantity + 1)} className="qty-btn">+</button>
                </div>
              </div>
              <button className="add-to-cart-btn" onClick={handleAddToCart} disabled={addingToCart}>
                <span className="cart-icon">🛒</span>
                {addingToCart ? 'ADDING...' : 'ADD TO CART'}
              </button>
              <button className={`wishlist-btn${isInWishlist ? ' active' : ''}`} title={isInWishlist ? 'Remove from Wishlist' : 'Add to Wishlist'} onClick={handleWishlistClick}>
                {isInWishlist ? (
                  <svg width="28" height="28" viewBox="0 0 24 24" fill="#ff1493" stroke="#ff1493" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" style={{ verticalAlign: 'middle', filter: 'drop-shadow(0 2px 6px #ffb6d5)' }}>
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" fill="#ff1493" stroke="#ff1493" />
                  </svg>
                ) : (
                  <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ff1493" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" style={{ verticalAlign: 'middle', filter: 'drop-shadow(0 2px 6px #ffb6d5)' }}>
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                  </svg>
                )}
              </button>
            </div>
            <div className="stock-status">🔥 Only 1 item left in stock</div>
            {/* Product Details */}
            <div className="product-details-tabs">
              <div className="tab-header">
                <button className="tab active">Brief Description</button>
              </div>
              <div className="tab-content">
                {product.short_description && (
                  <div className="description">
                    <div dangerouslySetInnerHTML={{ __html: product.short_description }} />
                  </div>
                )}
                <ul className="product-features">
                  <li>Product Name: {product.name}</li>
                  <li>SKU: {product.sku || 'N/A'}</li>
                </ul>
              </div>
            </div>
            {/* Product Meta */}
            <div className="product-meta">
              <div className="meta-row">
                <span className="meta-label">SKU</span>
                <span className="meta-value">{product.sku || 'N/A'}</span>
              </div>
              <div className="meta-row">
                <span className="meta-label">Categories</span>
                <span className="meta-value">{product.categories?.map((cat: any) => cat.name).join(', ') || 'Personal care'}</span>
              </div>
              <div className="meta-row">
                <span className="meta-label">Tags</span>
                <span className="meta-value">FMCG</span>
              </div>
              <div className="meta-row">
                <span className="meta-label">Brands</span>
                <span className="meta-value">{product.brand || 'Monalisa'}</span>
              </div>
            </div>
            {/* Trust Badges */}
            <div className="trust-badges">
              <div className="badge-item">
                <div className="badge-icon">✓</div>
                <div className="badge-text">
                  <strong>100% Genuine Products</strong>
                </div>
              </div>
              <div className="badge-item">
                <div className="badge-icon">🔒</div>
                <div className="badge-text">
                  <strong>100% Secure Payments</strong>
                </div>
              </div>
              <div className="badge-item">
                <div className="badge-icon">🎧</div>
                <div className="badge-text">
                  <strong>Help Center (+8809666737475)</strong>
                </div>
              </div>
            </div>
          </div>
        </div>
        {/* Full Description */}
        {product.description && (
          <div className="full-description">
            <h2>Product Description</h2>
            <div dangerouslySetInnerHTML={{ __html: product.description }} />
          </div>
        )}
      </div>
      {/* Toast Notification */}
      {showToast && <Toast message="Added to cart successfully!" type="success" onClose={() => setShowToast(false)} />}
      {wishlistToast.show && <Toast message={wishlistToast.message} type={wishlistToast.type} onClose={() => setWishlistToast({ show: false, message: '', type: 'success' })} />}
    </div>
  );
};

export default ProductDetailsPage;
