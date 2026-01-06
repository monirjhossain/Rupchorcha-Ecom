"use client";
import React, { useState, useEffect } from "react";
import Link from "next/link";
import { cartStorage } from "@/src/utils/cartStorage";
import styles from "./CartSidebar.module.css";

interface CartSidebarProps {
  isOpen: boolean;
  onClose: () => void;
  updateCartCount?: () => void;
}

interface CartItem {
  id: number;
  name: string;
  price: number;
  quantity: number;
  image?: string;
}

const CartSidebar: React.FC<CartSidebarProps> = ({ isOpen, onClose, updateCartCount }) => {
  const [cartItems, setCartItems] = useState<CartItem[]>([]);
  const [subtotal, setSubtotal] = useState(0);

  useEffect(() => {
    if (isOpen) {
      fetchCart();
    }
  }, [isOpen]);

  useEffect(() => {
    calculateSubtotal();
  }, [cartItems]);

  const fetchCart = () => {
    const cart = cartStorage.getCart();
    if (cart.items && Array.isArray(cart.items)) {
      setCartItems(cart.items);
    }
  };

  const calculateSubtotal = () => {
    const total = cartItems.reduce((sum, item) => {
      const price = parseFloat(item.price as any || 0);
      const quantity = parseInt(item.quantity as any || 0);
      return sum + price * quantity;
    }, 0);
    setSubtotal(total);
  };

  const removeItem = (itemId: number) => {
    try {
      cartStorage.removeItem(itemId);
      setCartItems(prevItems => prevItems.filter(item => item.id !== itemId));
      if (updateCartCount) updateCartCount();
    } catch (error) {
      console.error("Error removing item:", error);
    }
  };

  const updateQuantity = (itemId: number, newQuantity: number) => {
    if (newQuantity < 1) return;
    try {
      cartStorage.updateQuantity(itemId, newQuantity);
      setCartItems(prevItems =>
        prevItems.map(item =>
          item.id === itemId ? { ...item, quantity: newQuantity } : item
        )
      );
      if (updateCartCount) updateCartCount();
    } catch (error) {
      console.error("Error updating quantity:", error);
    }
  };

  if (!isOpen) return null;

  return (
    <aside className={styles.cartSidebar}>
      <div className={styles.cartSidebarHeader}>
        <h3>Shopping Cart</h3>
        <button className={styles.closeBtn} onClick={onClose}>×</button>
      </div>
      <div className={styles.cartSidebarBody}>
        {cartItems.length === 0 ? (
          <div className={styles.emptyCart}>Your cart is empty.</div>
        ) : (
          <ul className={styles.cartItemList}>
            {cartItems.map(item => (
              <li key={item.id} className={styles.cartItem}>
                <div className={styles.cartItemImgWrap}>
                  {item.image ? (
                    <img src={item.image} alt={item.name} className={styles.cartItemImg} />
                  ) : (
                    <div className={styles.cartItemImgPlaceholder}>📦</div>
                  )}
                </div>
                <div className={styles.cartItemInfo}>
                  <div className={styles.cartItemName}>{item.name}</div>
                  <div className={styles.cartItemPrice}>৳{item.price}</div>
                  <div className={styles.cartItemQtyWrap}>
                    <button onClick={() => updateQuantity(item.id, item.quantity - 1)}>-</button>
                    <span>{item.quantity}</span>
                    <button onClick={() => updateQuantity(item.id, item.quantity + 1)}>+</button>
                  </div>
                  <button className={styles.removeBtn} onClick={() => removeItem(item.id)}>Remove</button>
                </div>
              </li>
            ))}
          </ul>
        )}
      </div>
      <div className={styles.cartSidebarFooter}>
        <div className={styles.subtotal}>Subtotal: <b>৳{subtotal}</b></div>
        <Link href="/cart" className={styles.checkoutBtn} onClick={onClose}>
          Go to Cart
        </Link>
      </div>
    </aside>
  );
};

export default CartSidebar;
