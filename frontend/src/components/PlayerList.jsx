export const PlayerList = ({ list }) => {
  return (
    <ul className="p-0 list-none">
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
  )
}