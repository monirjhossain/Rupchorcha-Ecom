"use client";

import React, { useState } from "react";
import Link from "next/link";
import styles from "./ProductCard.module.css";

interface ProductCardProps {
  product: any;
  onAddToCart: (product: any) => void;
  isAddingToCart?: boolean;
}

const ProductCard: React.FC<ProductCardProps> = ({ product, onAddToCart, isAddingToCart = false }) => {
  // Multiple images support
  const images: string[] = product.images?.length
    ? product.images.map((img: any) => img.url || img.path)
    : [product.image || "https://via.placeholder.com/300x300/f0f0f0/999?text=No+Image"];
  const [imgIndex, setImgIndex] = useState(0);

  return (
    <div
      className={styles.productCard}
      onMouseEnter={() => images.length > 1 && setImgIndex(1)}
      onMouseLeave={() => setImgIndex(0)}
    >
      {/* Discount badge */}
      {product.special_price && (
        <div className={styles.discountBadge}>
          {Math.round((1 - product.special_price / product.price) * 100)}% OFF
        </div>
      )}
      {/* Product image */}
      <Link href={`/product/${product.id}`} className={styles.productImageLink}>
        <img
          src={images[imgIndex]}
          alt={product.name || "No Image Available"}
          className={styles.productImage}
        />
      </Link>
      {/* Product info */}
      <div className={styles.productInfo} style={{ marginTop: 4 }}>
        {/* Brand */}
        {product.brand?.name || product.brand_name ? (
          <div className={styles.brandName}>{product.brand?.name || product.brand_name}</div>
        ) : null}
        {/* Title */}
        <Link href={`/product/${product.id}`}>
          <h3 className={styles.productTitle}>{product.name}</h3>
        </Link>
        {/* Review */}
        {product.rating && (
          <div className={styles.reviewRow}>
            <span className={styles.stars}>{'★'.repeat(Math.round(product.rating))}{'☆'.repeat(5 - Math.round(product.rating))}</span>
            {product.reviews_count && (
              <span className={styles.reviewCount}>({product.reviews_count})</span>
            )}
          </div>
        )}
        {/* Price */}
        <div className={styles.productPrice} style={{ fontSize: 15, marginBottom: 4 }}>
          {product.special_price ? (
            <>
              <span className={styles.salePrice}>৳ {product.special_price}</span>
              <span className={styles.regularPrice}>৳ {product.price}</span>
            </>
          ) : (
            <span className={styles.salePrice}>৳ {product.price}</span>
          )}
        </div>
        {/* Cart Button */}
        <button
          className={`${styles.addToCartBtn} ${isAddingToCart ? styles.loading : ""}`}
          onClick={() => onAddToCart(product)}
          disabled={isAddingToCart}
        >
          {isAddingToCart ? "Adding..." : "Add to Cart"}
        </button>
      </div>
    </div>
  );
};
  return (
    <div className={styles.productCard}>
      {/* Icons row above image for guaranteed visibility */}
      <div style={{ display: "flex", justifyContent: "flex-end", marginBottom: 8 }}>
        <div className={styles.productCardIcons}>
          <button
            className={styles.quickviewBtn}
            title="Quick View"
            onClick={handleQuickViewClick}
          >
            {/* Icon can be added here */}
          </button>
        </div>
      </div>
      {/* Discount badge */}
      {product.special_price && (
        <div className={styles.discountBadge}>
          {Math.round((1 - product.special_price / product.price) * 100)}% OFF
        </div>
      )}
      {/* Product image */}
      <Link href={`/product/${product.id}`} className={styles.productImageLink}>
        <img
          src={
            product.images?.[0]?.url || product.images?.[0]?.path || product.image || "https://via.placeholder.com/300x300/f0f0f0/999?text=No+Image"
          }
          alt={product.name || "No Image Available"}
          className={styles.productImage}
        />
      </Link>
      {/* Product info */}
      <div className={styles.productInfo} style={{ marginTop: 4 }}>
        <Link href={`/product/${product.id}`}>
          <h3 className={styles.productTitle}>{product.name}</h3>
        </Link>
        <div className={styles.productPrice} style={{ fontSize: 15, marginBottom: 4 }}>
          {product.special_price ? (
            <>
              <span className={styles.salePrice}>৳ {product.special_price}</span>
              <span className={styles.regularPrice}>৳ {product.price}</span>
            </>
          ) : (
            <span className={styles.salePrice}>৳ {product.price}</span>
          )}
        </div>
        <button
          className={`${styles.addToCartBtn} ${isAddingToCart ? styles.loading : ""}`}
          onClick={() => onAddToCart(product)}
          disabled={isAddingToCart}
        >
          {isAddingToCart ? "Adding..." : "Add to Cart"}
        </button>
      </div>
    </div>
  );
};

export default ProductCard;
