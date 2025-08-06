import { useMemo } from 'react';

function calculatePlayerStats(players = []) {
  const stats = { total: 0, a: 0, e: 0, i: 0 };
  
  if (!Array.isArray(players)) return stats;

  stats.total = players.length;

  for (const player of players) {
    const name = (player?.name || '').toLowerCase();
    if (!name) continue;
    
    if (name.includes('a')) stats.a++;
    if (name.includes('e')) stats.e++;
    if (name.includes('i')) stats.i++;
  }
  
  return stats;
} 

export function usePlayerStats(filteredPlayers = []) {

  const stats = useMemo(() => {
    return calculatePlayerStats(filteredPlayers);
  }, [filteredPlayers]);

  return {
    stats,
    hasPlayers: filteredPlayers && filteredPlayers.length > 0
  };
} 

