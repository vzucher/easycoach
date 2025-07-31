import { useState, useEffect } from 'react'

export const RotatingSlogan = () => {
  const slogans = [
    'Pass. Shoot. Score. Repeat.',
    'Train Hard • Play Harder • Rest Hardest.',
    'Football is life – code is love ❤️',
    'Stay ahead of the game with EasyCoach!',
  ];
  const [index, setIndex] = useState(0);
  useEffect(() => {
    const id = setInterval(() => {
      const next = Math.floor(Math.random() * slogans.length);
      setIndex(next);
    }, 500);
    return () => clearInterval(id);
  }, []);
  return (
    <p className="text-[32px] font-bold text-[#1e88e5]">
      {slogans[index]}
    </p>
  );
}