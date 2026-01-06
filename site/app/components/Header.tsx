
import styles from './Header.module.css';
import Link from 'next/link';
import { useCategories } from '@/src/hooks/useCategories';


const Header: React.FC = () => {
  const { categories, isLoading } = useCategories();
  return (
    <header className={styles.header}>
      <div className={styles.headerInner}>
        <div className={styles.topBar}>
          <div className={styles.logoWrap}>
            <Link href="/">
              <img src="/rupchorcha-logo.png" alt="Logo" height={50} className={styles.logoImg} />
            </Link>
            <Link href="/brands" className={styles.brandsLink}>BRANDS</Link>
          </div>
          <form className={styles.searchWrap}>
            <span className={styles.searchIcon}>🔍</span>
            <input type="text" placeholder="Search for Products, Brands..." className={styles.searchInput} />
          </form>
          <div className={styles.actionBtns}>
            <Link href="/wishlist" className={styles.actionBtn + ' ' + styles.actionBtnDark}>WISHLIST</Link>
            <Link href="/login" className={styles.actionBtn + ' ' + styles.actionBtnLight}>LOGIN</Link>
            <Link href="/cart" className={styles.actionBtn + ' ' + styles.actionBtnPink}>
              <span className={styles.cartIcon}>🛒</span> BAG <span className={styles.cartCount}>0</span>
            </Link>
          </div>
        </div>
        <nav className={styles.categoryBar}>
          {isLoading ? (
            Array.from({ length: 8 }).map((_, i) => (
              <span key={i} className={styles.categoryLink + ' ' + styles.categorySkeleton}></span>
            ))
          ) : (
            categories.map(cat => (
              <Link
                href={"/category/"+cat.name.toLowerCase().replace(/\s+/g,'-')}
                key={cat.id}
                className={styles.categoryLink}
              >
                {cat.name}
              </Link>
            ))
          )}
        </nav>
      </div>
    </header>
  );
};

export default Header;
