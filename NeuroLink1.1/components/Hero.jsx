import React from 'react';
import '../App.css';

const Hero = () => {
  return (
    <section className="hero-section">
      <div id="home" className="recovaid-container">
        <h1><b className="abc">NeuroLink</b></h1>
        <div className="tagline">LOG → CONSULT → HEAL</div>

        <p className="description">
          Your One-Shot Guide for any medical needs. From simple health check-ups to complex surgeries, NeuroLink is here to help you navigate the medical world with ease. 
          We are INDIA's only online service offering 24 x 7 consultations with top doctors. NeuroLink is here for your needs anytime, anywhere.
        </p>

        <div className="stats-container">
          <div className="stat-item">
            <div className="stat-number">200+</div>
            <div className="stat-label">Expert Doctors</div>
          </div>

          <div className="stat-item">
            <div className="stat-number">8000+</div>
            <div className="stat-label">Active Users</div>
          </div>

          <div className="stat-item">
            <div className="stat-number">100+</div>
            <div className="stat-label">Diagnostic Centers</div>
          </div>
        </div>

        <div className="buttons-container">
          <a href="#" className="btn btn-primary">Explore Now</a>
          <a href="#contact" className="btn btn-outline">Contact Us</a>
        </div>
      </div>

      <div className="img-container">
        <img src="i1.png" alt="" />
      </div>

      <div id="features" className="divider"></div>
    </section>
  );
};

export default Hero;
