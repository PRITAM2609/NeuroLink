import React from 'react';
import '../App.css';

const featuresData = [
  {
    icon: '💬',
    title: 'Doctor Patient Connect',
    description: 'Your desired Consultant Doctor is just a click away. Connect with them anytime, anywhere.'
  },
  {
    icon: '📊',
    title: 'Analyze Stats',
    description: 'Upload your health-related issues and get detailed information and medications about it.'
  },
  {
    icon: '⏰',
    title: 'Auto Reminders',
    description: 'Automatically notify your doctor when a high-risk health status is detected—ensuring quick response when it matters most.'
  },
  {
    icon: '🗂️',
    title: 'Records Tracking',
    description: 'Save and access all your medical records in one place and review them anytime.'
  },
  {
    icon: '🤖',
    title: 'AI Health Assistant',
    description: 'Our AI analyzes your daily inputs to generate a summary and critical score, helping track risk and recovery at a glance.'
  },
  {
    icon: '🔒',
    title: 'Privacy First',
    description: 'Your data security is our first priority.'
  }
];

const Features = () => {
  return (
    <section className="features-container">
      <h1>Breakthrough Aspects</h1>
      <h2>All the essentials for your well-being in one go...</h2>

      <div className="features-grid">
        {featuresData.map((feature, index) => (
          <div key={index} className="feature-card">
            <div className="feature-icon">{feature.icon}</div>
            <h3 className="feature-title">{feature.title}</h3>
            <p className="feature-desc">{feature.description}</p>
          </div>
        ))}
      </div>

      <div id="faq" className="divider"></div>
    </section>
  );
};

export default Features;
