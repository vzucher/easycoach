export const NavBar = () => {
  return (
    <nav className="px-10 py-3 navbar">
      <div className="flex items-center justify-between">
        <div className="flex items-center gap-3">
          <img 
            src="/easycoach.png" 
            alt="EasyCoach Logo" 
            className="w-auto h-10 brightness-110"
          />
          <span className="text-2xl font-bold text-white drop-shadow-sm">
            Players & Sessions
          </span>
        </div>
        <div className="text-sm font-medium text-white/90">
          🚨 UNOPTIMISED Edition
        </div>
      </div>
    </nav>
  )
}