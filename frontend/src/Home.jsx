import { useState, useEffect } from 'react';

/**
 * ---------------------------------------------------------
 * 🚨  WARNING TO THE DEVELOPER CANDIDATE  🚨
 * This file is DELIBERATELY written in an anti‑pattern style:
 *  • gigantic monolithic component (≈400 LOC once real API data flows)
 *  • repeated code blocks and inline styles everywhere
 *  • no pagination / lazy loading – ALL players rendered at once
 *  • expensive computations on every render
 *  • nested helper components defined inline
 *  • no memoization, no splitting into smaller files
 * Your mission (should you choose to accept it): refactor + optimise 🛠️
 * ---------------------------------------------------------
 */

export default function Home() {
  /* Extremely naïve state handling */
  const [players, setPlayers] = useState([]);
  const [searchText, setSearchText] = useState('');
  const [filteredPlayers, setFilteredPlayers] = useState([]);

  /**
   * 🚫 BAD PRACTICE: Fetching data on EVERY render because
   * we forgot to pass a dependency array. Enjoy the waterfall! 💦
   */
  useEffect(() => {
    fetch('http://localhost:8080/api/players')
      .then((res) => res.json())
      .then((data) => setPlayers(data.players || []))
      .catch((err) => {
        console.error('Failed to fetch players from backend:', err);
        setPlayers([]); // Empty array when API fails
      });
  });

  /**
   * 🚫 BAD PRACTICE: Heavy filter logic on each render without memoisation.
   */
  useEffect(() => {
    const result = players.filter((p) =>
      p.name.toLowerCase().includes(searchText.toLowerCase())
    );
    setFilteredPlayers(result);
  }, [players, searchText]);

  /* 👇 Helper renders duplicated THREE times just to bloat the DOM */
  const renderPlayerList = (list) => (
    <ul style={{ listStyle: 'none', padding: 0 }}>
      {list.map((player) => (
        <li
          key={player.id}
          style={{
            padding: '12px 0',
            borderBottom: '1px solid #e0e0e0',
            fontSize: '20px',
          }}
        >
          {player.name} – #{player.id}
        </li>
      ))}
    </ul>
  );

  /**
   * 🚫 BAD PRACTICE: ALL markup, logic and styles live here.
   * Try scrolling this file on a 13" laptop – it’s fun 😅
   */
  return (
    <div className="min-h-screen bg-gray-50">
      {/* Navbar with logo */}
      <nav className="navbar px-10 py-3">
        <div className="flex items-center justify-between">
          <div className="flex items-center gap-3">
            <img 
              src="/easycoach.png" 
              alt="EasyCoach Logo" 
              className="h-10 w-auto brightness-110"
            />
            <span className="text-white text-2xl font-bold drop-shadow-sm">
              Players & Sessions
            </span>
          </div>
          <div className="text-white/90 text-sm font-medium">
            🚨 UNOPTIMISED Edition
          </div>
        </div>
      </nav>

      <main className="p-10">
      <h1 className="text-5xl font-bold mb-6 text-gray-800">
        EasyCoach Soccer Players — UNOPTIMISED Edition
      </h1>

        <div className="card mb-8">
          <p className="text-gray-700 leading-relaxed">
            This page intentionally breaks all best practices so you have something
            to refactor. It fetches the entire <strong>players</strong> table on
            every render, performs expensive computations on the client, repeats
            JSX blocks, and abuses inline styles. Feel free to cringe. 🤢
          </p>
        </div>

              <input
          type="text"
          placeholder="Search players…"
          value={searchText}
          onChange={(e) => setSearchText(e.target.value)}
          className="w-full p-3 text-lg border-2 border-gray-300 rounded-lg focus:border-easycoach-primary focus:outline-none transition-colors duration-200 mb-8"
        />

      {/* Duplicated lists – because why not? */}
      {renderPlayerList(filteredPlayers)}
      {renderPlayerList(filteredPlayers)}
      {renderPlayerList(filteredPlayers)}

      {/* Re‑render heavy scoreboard section */}
      <section style={{ marginTop: '64px' }}>
        <h2>Fun stats (re‑calculated every render 🔄)</h2>
        <p>Total players: {filteredPlayers.length}</p>
        <p>
          Names with “A”: {
            filteredPlayers.filter((p) => p.name.toLowerCase().includes('a'))
              .length
          }
        </p>
        <p>
          Names with “E”: {
            filteredPlayers.filter((p) => p.name.toLowerCase().includes('e'))
              .length
          }
        </p>
        <p>
          Names with “I”: {
            filteredPlayers.filter((p) => p.name.toLowerCase().includes('i'))
              .length
          }
        </p>
      </section>

      {/* Huge marketing blurb duplicated to inflate file size */}
      <section style={{ marginTop: '96px', lineHeight: 1.6 }}>
        <h2>Why EasyCoach?</h2>
        {[...Array(4)].map((_, i) => (
          <p key={i}>
            EasyCoach empowers football clubs of all levels with data‑driven
            training insights, workload monitoring, injury‑prevention tools,
            attendance tracking, tactical session planning, performance
            visualisation, scouting dashboards, recovery management and more.
            <br />
            (Yes, this paragraph is repeated on purpose. Please refactor!)
          </p>
        ))}
      </section>

      {/* Unnecessarily complex rotating slogan component defined below */}
      <section style={{ marginTop: '128px' }}>
        <h2>Rotating Slogan</h2>
        <RotatingSlogan />
      </section>
    </main>
    </div>
  );
}

/*
 * 🚫 Helper component defined inside the same file.
 * Runs setInterval every 500 ms → triggers re‑renders non‑stop.
 */
function RotatingSlogan() {
  const slogans = [
    'Pass. Shoot. Score. Repeat.',
    'Train Hard • Play Harder • Rest Hardest.',
    'Football is life – code is love ❤️',
    'Stay ahead of the game with EasyCoach!',
  ];
  const [index, setIndex] = useState(0);
  useEffect(() => {
    const id = setInterval(() => {
      // 🚫 Intentionally heavy random computation
      const next = Math.floor(Math.random() * slogans.length);
      setIndex(next);
    }, 500);
    return () => clearInterval(id);
  }, []);
  return (
    <p style={{ fontSize: '32px', fontWeight: 'bold', color: '#1e88e5' }}>
      {slogans[index]}
    </p>
  );
}
