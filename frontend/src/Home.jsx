import { useState, useEffect } from 'react';
import { NavBar } from './components/Navbar'
import { PageTitle } from './components/PageTitle'
import { WarningBar } from './components/WarningBar'
import { SearchBar } from './components/SearchBar'
import { PlayerList } from './components/PlayerList'

import { useDebounce } from './hooks/useDebounce';
import { Loading } from './components/Loading'
import { Stats } from './components/Stats'
import { MktBubble } from './components/MktBubble'
import { RotatingSlogan } from './components/RotatingSlogan'
import { Pagination } from './components/Pagination'

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
  const [players, setPlayers] = useState([]);
  const [searchTerm, setSearchTerm] = useState('');
  const [loading, setLoading] = useState(false);
  const [totalPlayers, setTotalPlayers] = useState(0);
  const [currentPage, setCurrentPage] = useState(1);
  const [perPage, setPerPage] = useState(10);

  const debouncedValue = useDebounce(searchTerm, 300);

  const fetchPlayers = async (term = '', page = 1) => {
    setLoading(true);
    let url = `http://localhost:8080/api/players?page=${page}&perPage=${perPage}`;

    if (term !== '') {
      url += `&search=${term}`;
    }

    try {
      const data = await fetch(url);
      const json = await data.json();
      setPlayers(json.players || []);
      setTotalPlayers(json.pagination.total || 0)
      setPerPage(json.pagination.perPage || 10);
    } catch(err) {
      setPlayers([]);
    } finally {
      setLoading(false);
    }
  }

  useEffect(() => {
    if (debouncedValue) {
      fetchPlayers(debouncedValue, currentPage);
    }
  }, [debouncedValue]);

  useEffect(() => {
    fetchPlayers(searchTerm, currentPage);
  }, [currentPage])

  const handlePageChange = (page) => {
    setCurrentPage(page);
  };
  
  return (
    <div className="min-h-screen bg-gray-50">
      {/* Navbar with logo */}
      <NavBar />

      <main className="p-10">
        <PageTitle />

        <WarningBar />

        <SearchBar onSearch={setSearchTerm} disabled={loading} />

      {loading && <Loading />}
      {!loading && players.length === 0 && <p>No players found</p>}
      {!loading && players.length > 0 && <PlayerList list={players} />}

      {!loading && players.length > 0 && <Pagination 
        totalItems={totalPlayers}
        itemsPerPage={perPage}
        currentPage={currentPage}
        onPageChange={handlePageChange}
      />}

      {/* Re‑render heavy scoreboard section */}
      {!loading && players.length > 0 && <Stats total={totalPlayers} players={players} />}
      

      {/* Huge marketing blurb duplicated to inflate file size */}
      <MktBubble />

      {/* Unnecessarily complex rotating slogan component defined below */}
      <section style={{ marginTop: '128px' }}>
        <h2>Rotating Slogan</h2>
        <RotatingSlogan />
      </section>
    </main>
    </div>
  );
}