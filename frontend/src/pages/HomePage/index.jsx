import SearchBar from '../../components/SearchBar';
import PlayerList from '../../components/PlayerList';
import PaginationControls from '../../components/PaginationControls';
import Loading from '../../components/Loading';
import Stats from '../../components/Stats';
import Section from '../../components/Section';
import RotatingSlogan from '../../components/RotatingSlogan';
import { usePlayers } from '../../hooks/usePlayers';
import './styles.css';

export default function HomePage() {
  const {
    players,
    searchText,
    pagination,
    loading,
    error,
    handlePageChange,
    handlePerPageChange,
    handleSearchChange
  } = usePlayers();

  return (
    <main id="main-content" className="homepage-main">
      <h1 className="homepage-title">
        EasyCoach Soccer Players
      </h1>

      <SearchBar searchText={searchText} setSearchText={handleSearchChange} />

      <PaginationControls 
        pagination={pagination}
        handlePageChange={handlePageChange}
        handlePerPageChange={handlePerPageChange}
      />

      {error ? (
        <div className="error-message">
          <strong>Error:</strong> {error}
        </div>
      ) : loading ? (
        <Loading />
      ) : (
        <>
          <PlayerList players={players} />
          <Stats filteredPlayers={players} />
        </>
      )}
      
      <Section 
        title="Why EasyCoach?"
        content="EasyCoach empowers football clubs of all levels with data‑driven training insights, workload monitoring, injury‑prevention tools, attendance tracking, tactical session planning, performance visualisation, scouting dashboards, recovery management and more."
      />
      
      <RotatingSlogan slogans={[
        'Pass. Shoot. Score. Repeat.',
        'Train Hard • Play Harder • Rest Hardest.',
        'Football is life – code is love ❤️',
        'Stay ahead of the game with EasyCoach!',
      ]} />
    </main>
  );
} 