import React from 'react';
import './styles.css';

const PlayerList = ({ players }) => {
  if (!players || players.length === 0) {
    return (
      <div className="player-list-empty" role="status" aria-live="polite">
        <p className="empty-message">
          No players found matching your criteria.
        </p>
      </div>
    );
  }

  return (
    <ul 
      className="player-list" 
      role="list"
      aria-label="List of soccer players"
    >
      {players.map((player) => (
        <li 
          key={player.id} 
          className="player-item"
          role="listitem"
          aria-label={`Player ${player.name}, ID ${player.id}`}
        >
          <span className="player-name">{player.name}</span>
          <span className="player-id" aria-label="Player ID">#{player.id}</span>
        </li>
      ))}
    </ul>
  );
};

export default PlayerList; 