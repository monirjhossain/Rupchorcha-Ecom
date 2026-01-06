
"use client";
import Image from 'next/image';

const categories = [
  { id: 1, image: '/category/ujjwala-care.webp', alt: 'Ujjwala Care' },
  { id: 2, image: '/category/skin-sale.webp', alt: 'Skin Sale' },
  { id: 3, image: '/category/vatika.webp', alt: 'Vatika' },
  { id: 4, image: '/category/treasure-glow.webp', alt: 'Treasure of Glow' },
  { id: 5, image: '/category/neutrogena.webp', alt: 'Neutrogena' },
  { id: 6, image: '/category/jewellery.webp', alt: 'Jewellery' },
];

const ShopByCategorySection = () => {
  return (
    <section>
      <h2>Shop By Categories</h2>
      <div style={{display:'flex',gap:'1rem',flexWrap:'wrap',justifyContent:'center'}}>
        {categories.map(cat => (
          <div key={cat.id} style={{width:120,height:120,display:'flex',alignItems:'center',justifyContent:'center',background:'#fafafa',borderRadius:12,boxShadow:'0 1px 4px #0001'}}>
            <Image src={cat.image} alt={cat.alt} width={80} height={80} style={{objectFit:'contain'}} />
          </div>
        ))}
      </div>
    </section>
  );
};

export default ShopByCategorySection;
