import React from 'react';
import { usePlayerStats } from '../../hooks/usePlayerStats';
import './styles.css';

const Stats = ({ filteredPlayers = [] }) => {
  const { stats } = usePlayerStats(filteredPlayers);

  const maxValue = Math.max(stats.total, stats.a, stats.e, stats.i);
  const chartData = [
    { label: 'Total', value: stats.total, color: '#3B82F6' },
    { label: 'With "A"', value: stats.a, color: '#10B981' },
    { label: 'With "E"', value: stats.e, color: '#F59E0B' },
    { label: 'With "I"', value: stats.i, color: '#EF4444' }
  ];

  return (
    <section className="stats-section">
      <h2>Fun stats</h2>
      <div className="stats-chart">
        <h3 className="chart-title">Player Statistics Chart</h3>
        <div className="chart-container">
          {chartData.map((item, index) => (
            <div key={index} className="chart-bar-group">
              <div className="chart-bar-wrapper">
                <div 
                  className="chart-bar"
                  style={{
                    height: `${maxValue > 0 ? (item.value / maxValue) * 200 : 0}px`,
                    backgroundColor: item.color
                  }}
                  title={`${item.label}: ${item.value}`}
                >
                  <span className="bar-value">{item.value}</span>
                </div>
              </div>
              <div className="bar-label">{item.label}</div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
};

export default React.memo(Stats);
