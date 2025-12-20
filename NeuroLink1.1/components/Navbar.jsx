import React from 'react';
import '../App.css';

const Navbar = () => {
  return (
    <header class="navbar">
    <div class="logo">NeuroLink</div>
    
    <nav class="center-nav">
        <a href="#home" class="nav-link">Home</a>
        <a href="#features" class="nav-link">Features</a>
        <a href="#aboutus" class="nav-link">About Us</a>
        <a href="#faq" class="nav-link">FAQ</a>
    </nav>
    
    <div class="right-nav">
        <a 
          className="register-btn" 
          /*href="http://localhost/hospital_management/"*/
          href="http://localhost/NeuroLink(All)/hospital_management/"
          target="_blank"
          rel="noopener noreferrer"
        >
          Register Now
        </a>
    </div>
    </header>
  );
};

export default Navbar;

