import React, { useState } from 'react';
import '../App.css';

const faqData = [
  {
    question: 'What is NeuroLink?',
    answer: 'NeuroLink is a comprehensive medical platform designed to help patients track their health status, communicate with doctors, and manage their medical needs effectively. It uses AI to analyze health data and provide personalized insights.'
  },
  {
    question: 'What happens if my health status is critical?',
    answer: 'If your health status is marked as critical, our system will immediately notify your healthcare provider and, depending on your settings, may also alert your emergency contacts. You\'ll receive prompt guidance on the next steps to take.'
  },
  {
    question: 'Can I track my medical history?',
    answer: 'Yes, NeuroLink provides comprehensive tools to track your medical history. You can monitor various health metrics, view your improvement over time, and receive personalized feedback based on your health goals.'
  },
  {
    question: 'Is my personal health data safe?',
    answer: 'Absolutely. We use industry-standard encryption and security measures to protect your personal health data. Your information is only shared with your healthcare providers and anyone else you explicitly authorize.'
  }
];

const FAQ = () => {
  const [activeIndex, setActiveIndex] = useState(null);

  const toggleAnswer = (index) => {
    setActiveIndex(activeIndex === index ? null : index);
  };

  return (
    <section id="faq">
      <div className="divider"></div>

      <h1>Frequently Asked Questions</h1>
      <p className="intro">
        <strong>Got questions? We're here to help you through every step of your recovery journey.</strong>
      </p>

      <div className="faq-container">
        {faqData.map((item, index) => (
          <div key={index} className="faq-item">
            <h3
              className={`faq-question ${activeIndex === index ? 'active' : ''}`}
              onClick={() => toggleAnswer(index)}
            >
              {item.question}
            </h3>
            {activeIndex === index && (
              <div className="faq-answer show">{item.answer}</div>
            )}
          </div>
        ))}
      </div>
    </section>
  );
};

export default FAQ;
