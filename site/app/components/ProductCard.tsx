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
  // Build image URL from main_image, image, or fallback
  let imageUrl = "https://via.placeholder.com/300x300/f0f0f0/999?text=No+Image";
  const backendBase = "http://localhost:8000";
  if (product.images?.length) {
    const img = product.images[0].url || product.images[0].path;
    if (img) {
      imageUrl = img.startsWith("http") ? img : `${backendBase}/storage/${img.replace(/^storage[\\/]/, "")}`;
    }
  } else if (product.main_image) {
    imageUrl = product.main_image.startsWith("http")
      ? product.main_image
      : `${backendBase}/storage/${product.main_image.replace(/^storage[\\/]/, "")}`;
  } else if (product.image) {
    imageUrl = product.image.startsWith("http")
      ? product.image
      : `${backendBase}/storage/${product.image.replace(/^storage[\\/]/, "")}`;
  }
  const images: string[] = [imageUrl];
  const [imgIndex, setImgIndex] = useState(0);

  return (
    <div
      className={styles.productCard}
      onMouseEnter={() => images.length > 1 && setImgIndex(1)}
      onMouseLeave={() => setImgIndex(0)}
    >
      {/* Badges */}
      <div className={styles.badgeContainer}>
          {product.is_new && <span className={styles.newBadge}>NEW</span>}
          {product.special_price && <span className={styles.saleBadge}>SALE</span>}
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
          src={images[imgIndex]}
          alt={product.name || "No Image Available"}
          className={styles.productImage}
        />
      </Link>
      {/* Product info */}
      <div className={styles.productInfo}>
        {/* Brand */}
        {product.brand?.name || product.brand_name ? (
          <div className={styles.brandName}>{product.brand?.name || product.brand_name}</div>
        ) : null}
        {/* Title */}
        <Link href={`/product/${product.id}`}>
          <h3 className={styles.productTitle}>{product.name}</h3>
        </Link>
        {/* Price */}
        <div className={styles.productPrice}>
          {product.special_price && product.special_price < product.price ? (
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

export default ProductCard;
