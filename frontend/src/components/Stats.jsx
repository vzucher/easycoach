export const Stats = ({ total, players}) => {
  return (
    <section className="mt-16">
      <h2>Fun stats (re‑calculated every render 🔄)</h2>
      <p>Total players: {total}</p>
      <p>
        Names with “A”: {
          players.filter((p) => p.name.toLowerCase().includes('a'))
            .length
        }
      </p>
      <p>
        Names with “E”: {
          players.filter((p) => p.name.toLowerCase().includes('e'))
            .length
        }
      </p>
      <p>
        Names with “I”: {
          players.filter((p) => p.name.toLowerCase().includes('i'))
            .length
        }
      </p>
    </section>
  )
}