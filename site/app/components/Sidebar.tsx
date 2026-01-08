"use client";
import React, { useState, useRef, useEffect } from "react";
import { categoriesAPI, brandsAPI } from "../services/api";

// Remove all mockCategories and mockBrands. Only use backend data for categories and brands.


const Sidebar = () => {
  const [price, setPrice] = useState([0, 15000]);
  const minPrice = 0;
  const maxPrice = 15000;
  const sliderRef = useRef(null);

  // Handle slider drag
  const handleSliderChange = (idx: 0 | 1, value: number) => {
    let newPrice = [...price];
    if (idx === 0) {
  const [categories, setCategories] = useState<any[]>([]);
  const [brands, setBrands] = useState<any[]>([]);
      newPrice[1] = Math.max(value, price[0] + 1);
    }
    setPrice(newPrice);
  };
  const [showAllBrands, setShowAllBrands] = useState(false);
  const [brandSearch, setBrandSearch] = useState("");
  const [showAllCategories, setShowAllCategories] = useState(false);
  const [categorySearch, setCategorySearch] = useState("");
  const [showPrice, setShowPrice] = useState(true);
  const [showCategories, setShowCategories] = useState(true);
  const [showBrandsSection, setShowBrandsSection] = useState(true);
  const [categories, setCategories] = useState<string[]>([]);
  const [brands, setBrands] = useState<string[]>([]);
  useEffect(() => {
    async function fetchData() {
      try {
        const categoriesRes = await categoriesAPI.getAll();
        setCategories(Array.isArray(categoriesRes) ? categoriesRes : categoriesRes.categories || []);
        const brandsRes = await brandsAPI.getAll();
        setBrands(Array.isArray(brandsRes) ? brandsRes : brandsRes.brands || []);
      } catch (e) {
        setCategories([]);
        setBrands([]);
      }
    }
    fetchData();
  }, []);
  const brandsToShow = showAllBrands ? brands : brands.slice(0, 10);
  const categoriesToShow = showAllCategories ? categories : categories.slice(0, 10);

  return (
    <aside style={{width:300, minWidth:220, background:'#fff', borderRadius:14, boxShadow:'0 4px 24px #0001', padding:'2.2rem 1.5rem', marginRight:'1.5rem', fontSize:'1rem', position:'sticky', top:24, alignSelf:'flex-start', maxHeight:'90vh', overflowY:'auto', border:'1px solid #f2f2f2'}}>
      {/* Price Filter (collapsible) */}
      <div style={{marginBottom:'2.2rem',borderBottom:'1px solid #f2f2f2',paddingBottom:'1.5rem'}}>
        <div style={{display:'flex',alignItems:'center',justifyContent:'space-between',marginBottom:'0.7rem',cursor:'pointer',userSelect:'none'}} onClick={()=>setShowPrice(v=>!v)}>
          <span style={{fontWeight:700,fontSize:'1.13rem',letterSpacing:'0.01em'}}>Price</span>
          <span style={{fontSize:'1.2rem',fontWeight:600,color:'#888',border:'1.5px solid #e91e63',borderRadius:4,width:22,height:22,display:'flex',alignItems:'center',justifyContent:'center'}}>
            <svg width="14" height="14" style={{transform:showPrice?'rotate(0deg)':'rotate(-90deg)',transition:'transform 0.2s'}}>
              <polyline points="3,6 7,10 11,6" fill="none" stroke="#e91e63" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" />
            </svg>
          </span>
        </div>
        {showPrice && (
          <>
            {/* Real price range slider */}
            <div style={{display:'flex',alignItems:'center',gap:'0.5rem',margin:'1.2rem 0 0.7rem 0',position:'relative',height:32}}>
              <div style={{flex:1,position:'relative',height:8,background:'#eee',borderRadius:4}} ref={sliderRef}>
                {/* Active range */}
                <div style={{position:'absolute',left:`${((price[0]-minPrice)/(maxPrice-minPrice))*100}%`,right:`${100-((price[1]-minPrice)/(maxPrice-minPrice))*100}%`,top:0,bottom:0,background:'#e91e63',borderRadius:4}}></div>
                {/* Min thumb */}
                <input
                  type="range"
                  min={minPrice}
                  max={maxPrice-1}
                  value={price[0]}
                  onChange={e=>handleSliderChange(0, +e.target.value)}
                  style={{position:'absolute',left:0,top:-8,width:'100%',height:24,background:'none',WebkitAppearance:'none',zIndex:2,pointerEvents:'auto'}}
                />
                {/* Max thumb */}
                <input
                  type="range"
                  min={minPrice+1}
                  max={maxPrice}
                  value={price[1]}
                  onChange={e=>handleSliderChange(1, +e.target.value)}
                  style={{position:'absolute',left:0,top:-8,width:'100%',height:24,background:'none',WebkitAppearance:'none',zIndex:3,pointerEvents:'auto'}}
                />
              </div>
            </div>
            <div style={{display:'flex',alignItems:'center',gap:'0.7rem',marginTop:'1.2rem'}}>
              <input type="number" value={price[0]} min={minPrice} max={price[1]-1} onChange={e=>handleSliderChange(0, +e.target.value)} style={{width:80,padding:'0.5rem',border:'1px solid #eee',borderRadius:6,textAlign:'center',fontWeight:500}} />
              <span style={{color:'#aaa',fontWeight:600,fontSize:'1.1rem'}}>-</span>
              <input type="number" value={price[1]} min={price[0]+1} max={maxPrice} onChange={e=>handleSliderChange(1, +e.target.value)} style={{width:80,padding:'0.5rem',border:'1px solid #eee',borderRadius:6,textAlign:'center',fontWeight:500}} />
            </div>
          </>
        )}
      </div>
        {/* No brandsToShow.filter or categoriesToShow.filter outside JSX here. All filter/map logic is inside <ul>...</ul> in the correct filter sections. */}
      {/* Category Filter (collapsible) */}
      <div style={{marginBottom:'2.2rem',borderBottom:'1px solid #f2f2f2',paddingBottom:'1.5rem'}}>
        <div style={{display:'flex',alignItems:'center',justifyContent:'space-between',marginBottom:'0.7rem',cursor:'pointer',userSelect:'none'}} onClick={()=>setShowCategories(v=>!v)}>
          <span style={{fontWeight:700,fontSize:'1.13rem',letterSpacing:'0.01em'}}>Categories</span>
          <span style={{fontSize:'1.2rem',fontWeight:600,color:'#888',border:'1.5px solid #e91e63',borderRadius:4,width:22,height:22,display:'flex',alignItems:'center',justifyContent:'center'}}>
            <svg width="14" height="14" style={{transform:showCategories?'rotate(0deg)':'rotate(-90deg)',transition:'transform 0.2s'}}>
              <polyline points="3,6 7,10 11,6" fill="none" stroke="#e91e63" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" />
            </svg>
          </span>
        </div>
        {showCategories && (
          <>
            <input type="text" value={categorySearch} onChange={e=>setCategorySearch(e.target.value)} placeholder="Search category..." style={{width:'100%',padding:'0.5rem',border:'1px solid #eee',borderRadius:6,marginBottom:'0.75rem',fontSize:'1rem'}} />
            <ul style={{listStyle:'none',padding:0,margin:0,maxHeight:180,overflowY:'auto'}}>
              {categoriesToShow.filter(c => c.name && c.name.toLowerCase().includes(categorySearch.toLowerCase())).map((cat) => (
                <li key={cat.id} style={{marginBottom:'0.5rem',display:'flex',alignItems:'center',gap:'0.5rem'}}>
                  <input type="checkbox" style={{accentColor:'#e91e63',width:18,height:18}} />
                  <span style={{fontWeight:500,color:'#444',fontSize:'1rem'}}>{cat.name} <span style={{color:'#aaa',fontWeight:400}}>(100)</span></span>
                </li>
              ))}
            </ul>
            <div style={{marginTop:'0.7rem',textAlign:'left'}}>
              <button onClick={e=>{e.stopPropagation();setShowAllCategories(v=>!v);}} style={{background:'none',border:'none',color:'#444',cursor:'pointer',fontWeight:500,fontSize:'1rem',textDecoration:'underline'}}>
                {showAllCategories ? '- Show less' : '+ Show more'}
              </button>
            </div>
          </>
        )}
      </div>
      {/* Brands Filter (collapsible) */}
      <div style={{marginBottom:'2.2rem'}}>
        <div style={{display:'flex',alignItems:'center',justifyContent:'space-between',marginBottom:'0.7rem',cursor:'pointer',userSelect:'none'}} onClick={()=>setShowBrandsSection(v=>!v)}>
          <span style={{fontWeight:700,fontSize:'1.13rem',letterSpacing:'0.01em'}}>Brands</span>
          <span style={{fontSize:'1.2rem',fontWeight:600,color:'#888',border:'1.5px solid #e91e63',borderRadius:4,width:22,height:22,display:'flex',alignItems:'center',justifyContent:'center'}}>
            <svg width="14" height="14" style={{transform:showBrandsSection?'rotate(0deg)':'rotate(-90deg)',transition:'transform 0.2s'}}>
              <polyline points="3,6 7,10 11,6" fill="none" stroke="#e91e63" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" />
            </svg>
          </span>
        </div>
        {showBrandsSection && (
          <>
            <input type="text" value={brandSearch} onChange={e=>setBrandSearch(e.target.value)} placeholder="Search brand..." style={{width:'100%',padding:'0.5rem',border:'1px solid #eee',borderRadius:6,marginBottom:'0.75rem',fontSize:'1rem'}} />
            <ul style={{listStyle:'none',padding:0,margin:0,maxHeight:180,overflowY:'auto'}}>
              {brandsToShow.filter(b => b.name && b.name.toLowerCase().includes(brandSearch.toLowerCase())).map((brand) => (
                <li key={brand.id} style={{marginBottom:'0.5rem',display:'flex',alignItems:'center',gap:'0.5rem'}}>
                  <input type="checkbox" style={{accentColor:'#e91e63',width:18,height:18}} />
                  <span style={{fontWeight:500,color:'#444',fontSize:'1rem'}}>{brand.name} <span style={{color:'#aaa',fontWeight:400}}>(100)</span></span>
                </li>
              ))}
            </ul>
            <div style={{marginTop:'0.7rem',textAlign:'left'}}>
              <button onClick={e=>{e.stopPropagation();setShowAllBrands(v=>!v);}} style={{background:'none',border:'none',color:'#444',cursor:'pointer',fontWeight:500,fontSize:'1rem',textDecoration:'underline'}}>
                {showAllBrands ? '- Show less' : '+ Show more'}
              </button>
            </div>
          </>
        )}
      </div>
    </aside>
  );
};

export default Sidebar;
