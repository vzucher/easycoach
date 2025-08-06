import React from 'react';
import logo from '/assets/images/easycoach.png';
import './styles.css';

const Header = () => {
  return (
    <header>      
      <nav className="navbar px-10 py-3" aria-label="Primary">
        <div className="flex items-center justify-between">
          <div className="flex items-center gap-3">
            <img 
              src={logo} 
              alt="EasyCoach Logo" 
              className="h-10 w-auto brightness-110"
            />
            <span className="text-white text-2xl font-bold drop-shadow-sm">
              Players & Sessions
            </span>
          </div>
        </div>
      </nav>
    </header>
  );
};

export default Header; 