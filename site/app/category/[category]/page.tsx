"use client";
import React from "react";
import { useParams } from "next/navigation";

import dynamic from "next/dynamic";
const Header = dynamic(() => import("../../components/Header"), { ssr: false });
const Sidebar = dynamic(() => import("../../components/Sidebar"), { ssr: false });
const CategoryProductsPage = dynamic(() => import("../../features/category/categoryProducts/page"), { ssr: false });

const CategoryPage = () => {
  const params = useParams();
  const category = params.category as string;
  const displayName = category.replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase());

  return (
    <>
      <Header />
      <div style={{display:'flex',gap:'2rem',alignItems:'flex-start',maxWidth:1400,margin:'2rem auto',padding:'0 1rem'}}>
        <Sidebar />
        <div style={{flex:1}}>
          {/* Category Title */}
          <div style={{fontSize:'1.7rem',fontWeight:'bold',color:'#222',marginBottom:'0.5rem',marginTop:'0.5rem',textAlign:'center'}}>{displayName} Products</div>
          {/* Product Grid: Use backend data */}
          <CategoryProductsPage params={{ slug: category }} />
        </div>
      </div>
    </>
  );
};

export default CategoryPage;
