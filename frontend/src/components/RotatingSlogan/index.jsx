import React, { useState, useEffect } from 'react';
import './styles.css';

const RotatingSlogan = ({ slogans = [], interval = 500 }) => {
  const [index, setIndex] = useState(0);
  
  useEffect(() => {
    if (slogans.length === 0) return;
    
    const id = setInterval(() => {
      const next = Math.floor(Math.random() * slogans.length);
      setIndex(next);
    }, interval);
    return () => clearInterval(id);
  }, [slogans.length, interval]);
  
  if (slogans.length === 0) {
    return null;
  }
  
  return (
    <section className="slogan-section">
      <h2 className="text-2xl font-bold mb-4 text-gray-800">Motivational Slogans</h2>
      <p className="rotating-slogan">
        {slogans[index]}
      </p>
    </section>
  );
};

export default RotatingSlogan; 