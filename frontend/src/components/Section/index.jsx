import React from 'react';
import './styles.css';

export default function Section({ title, content }) {
  return (
    <section>
      <h2>{title}</h2>
      <p>{content}</p>
    </section>
  );
} 