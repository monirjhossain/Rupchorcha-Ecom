"use client";
import React, { useState, useEffect, useRef } from "react";
import { useRouter } from "next/navigation";
import styles from "./SearchBox.module.css";
// TODO: Update API imports for Next.js
// import { productsAPI, categoriesAPI } from "@/src/services/api";

const SearchBox = () => {
  const [searchQuery, setSearchQuery] = useState("");
  const [searchResults, setSearchResults] = useState({
    products: [],
    categories: [],
    brands: []
  });
  const [isDropdownOpen, setIsDropdownOpen] = useState(false);
  const [loading, setLoading] = useState(false);
  const searchRef = useRef(null);
  const router = useRouter();

  useEffect(() => {
    const handleClickOutside = (event) => {
      if (searchRef.current && !searchRef.current.contains(event.target)) {
        setIsDropdownOpen(false);
      }
    };
    document.addEventListener("mousedown", handleClickOutside);
    return () => document.removeEventListener("mousedown", handleClickOutside);
  }, []);

  useEffect(() => {
    const delaySearch = setTimeout(() => {
      if (searchQuery.trim().length >= 2) {
        performSearch(searchQuery);
      } else {
        setSearchResults({ products: [], categories: [], brands: [] });
        setIsDropdownOpen(false);
      }
    }, 300);
    return () => clearTimeout(delaySearch);
  }, [searchQuery]);

  // Dummy search function for migration (replace with real API)
  const performSearch = async (query) => {
    setLoading(true);
    setIsDropdownOpen(true);
    // TODO: Replace with real API calls
    setTimeout(() => {
      setSearchResults({
        products: [],
        categories: [],
        brands: []
      });
      setLoading(false);
    }, 500);
  };

  const handleProductClick = (product) => {
    router.push(`/product/${product.slug}`);
    setIsDropdownOpen(false);
    setSearchQuery("");
  };

  const handleCategoryClick = (category) => {
    router.push(`/category/${category.slug || category.id}`);
    setIsDropdownOpen(false);
    setSearchQuery("");
  };

  const handleSearchSubmit = (e) => {
    e.preventDefault();
    if (searchQuery.trim()) {
      router.push(`/search?q=${encodeURIComponent(searchQuery)}`);
      setIsDropdownOpen(false);
    }
  };

  return (
    <div className={styles.searchBoxContainer} ref={searchRef}>
      <form onSubmit={handleSearchSubmit} className={styles.searchBox}>
        <div className={styles.searchIcon}>🔍</div>
        <input
          type="text"
          className={styles.searchboxInput}
          placeholder="Search for Products, Brands..."
          value={searchQuery}
          onChange={(e) => setSearchQuery(e.target.value)}
          onFocus={() => searchQuery.length >= 2 && setIsDropdownOpen(true)}
        />
        {searchQuery && (
          <button
            type="button"
            className={styles.clearBtn}
            onClick={() => {
              setSearchQuery("");
              setIsDropdownOpen(false);
            }}
          >
            ✕
          </button>
        )}
      </form>
      {isDropdownOpen && (
        <div className={styles.searchDropdown}>
          {loading ? (
            <div className={styles.searchLoading}>
              <div className={styles.spinner}></div>
              <span>Searching...</span>
            </div>
          ) : (
            <div className={styles.noResults}>No results found</div>
          )}
        </div>
      )}
    </div>
  );
};

export default SearchBox;
