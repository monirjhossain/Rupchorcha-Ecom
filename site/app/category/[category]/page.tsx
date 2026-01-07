"use client";
import React from "react";
import { useParams } from "next/navigation";
import Sidebar from "../../components/Sidebar";
import Header from "../../components/Header";
// Removed unused imports after mock data removal

// Remove all mock data. Use only backend data. (Implementation for fetching real data should be added here if not already.)

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
          {/* Category Icons Row removed (was mock data) */}
          {/* Product Grid removed (was mock data). Use backend data grid here. */}
        </div>
      </div>
    </>
  );
};

export default CategoryPage;
