import React from 'react';
import './App.css';
import Navbar from './components/Navbar';
import Hero from './components/Hero';
import Features from './components/Features';
import FAQ from './components/FAQ';
import Footer from './components/Footer';

function App() {
  return (
    <div className="App">
      <Navbar />
      <Hero />
      <div className="divider"></div>
      <Features />
      <div className="divider"></div>
      <FAQ />
      <div className="divider"></div>
      <Footer />
    </div>
  );
}

export default App;