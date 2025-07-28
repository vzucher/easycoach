# ⚽️ EasyCoach Challenge
_Full-stack developer technical assessment_

---

## 📋 What You're Building

A **"Players & Sessions" module** for EasyCoach.Club - list players with pagination, search, and training load visualization.

**Time limit**: 5 hours ⏱️  
**Tech stack**: PHP 8.3 + SQLite + React 18 + Vite + Tailwind CSS  

---

## 🗂️ Repository Structure

```
easycoach/
├── 🔧 docker-compose.yml       # Zero-install dev environment
├── 📊 seed/
│   └── hello.db                # SQLite dataset (100 players)  
├── 🖥️ backend/                 # PHP API (simplified for rapid development)
│   ├── app/
│   │   └── Controllers/        # API controllers
│   ├── public/
│   │   ├── index.php          # API entry point
│   │   └── api.php            # Standalone API logic
│   └── composer.json
├── 🎨 frontend/                # React 18 + Vite app
│   ├── src/
│   │   ├── components/         # Extract components here
│   │   └── Home.jsx           # 199 LOC monolith to refactor  
│   └── package.json
└── 📈 bin/
    └── benchmark.php          # Performance testing script
```

---

## 🚀 Quick Start

### 1. Spin up everything with Docker

```bash
# Start all services (backend, frontend, database)
docker compose up -d

# Wait ~30 seconds for services to start
# Then open:
open http://localhost:5173    # 🎨 React frontend
open http://localhost:8080    # 🔧 PHP API
```

**Services running:**
- 🎨 **Frontend**: http://localhost:5173 (React + Vite + Tailwind)
- 🔧 **Backend**: http://localhost:8080 (PHP + SQLite)  
- 🗄️ **Database**: SQLite file at `seed/hello.db`

### 2. Test API endpoints

```bash
# List all players (⚠️ currently returns all 100 at once!)
curl http://localhost:8080/api/players

# Search players
curl "http://localhost:8080/api/players?search=messi"

# Health check
curl http://localhost:8080/api/health
```

---

## 🔧 Backend Challenge (60% of score)

### 🚨 **Current Performance Issues to Fix:**

The backend currently has **intentional performance problems**:

1. **🚫 No Pagination**: API returns all 100 players at once
2. **💾 Inefficient Queries**: No database optimization
3. **⚠️ Poor Architecture**: Monolithic API file instead of proper MVC

### Your Mission:

1. **🛠️ Implement Proper Pagination**
   | Method | Route | Description |
   |--------|-------|-------------|
   | `GET /api/players` | List players | Add `?page=1&perPage=10` support |
   | `GET /api/players/{id}` | Player details | Individual player with stats |
   | `GET /api/players/{id}/sessions` | Player sessions | Mock session data with pagination |

2. **📈 Optimize Database Queries**
   - Add proper SQLite indexes for fast queries
   - Implement efficient pagination with `LIMIT` and `OFFSET`
   - Add search optimization for name filtering

3. **🏗️ Improve Architecture**
   - Refactor monolithic `api.php` into proper MVC structure
   - Separate database logic from API logic  
   - Add proper error handling and validation
   - Optional: Migrate to full CodeIgniter 4 structure

4. **📊 Performance Benchmarking**
   - Measure query performance before/after optimization
   - Test with different page sizes and search queries
   - Document improvements in README

---

## 🎨 Frontend Challenge (40% of score)

### 🚨 **Current Performance Issues to Fix:**

The frontend currently has **intentional React problems**:

1. **🔄 Infinite Re-renders**: `useEffect` with no dependency array
2. **⚡ Heavy Filtering**: Unoptimized search on every keystroke  
3. **🖼️ Monolithic Component**: 199-line `Home.jsx` doing everything
4. **💾 No Memoization**: Expensive operations on every render

### Your Mission:

1. **♻️ Refactor the Monolithic `Home.jsx`**
   - Break into reusable components:
     - `PlayerTable` or `PlayerList`
     - `SearchBar` 
     - `PaginationControls`
   - Fix the infinite re-render issues
   - Optimize filtering with `useMemo`

2. **🔗 Integrate Real API Pagination**
   - Remove mock data fallback
   - Implement proper pagination controls
   - Add loading states for API calls
   - Handle API errors gracefully

3. **✨ UX Requirements**
   - ✅ Working pagination with backend
   - ⏳ Loading spinners during API calls
   - ❌ Error boundaries and user-friendly error messages
   - 📱 Responsive design (already has Tailwind CSS)

4. **🌟 Extra Credit**
   - 🔍 Debounced search (300ms delay)
   - ♾️ Infinite scroll as alternative to pagination
   - 📊 Player statistics visualization

---

## 🎯 Success Criteria & Deliverables

### ✅ What Success Looks Like:

**Backend (60%)**:
- ✅ Pagination implemented (`?page=1&perPage=10`)
- ✅ Database queries optimized (< 50ms response time)
- ✅ API architecture improved (separated concerns)
- ✅ Search functionality working efficiently

**Frontend (40%)**:
- ✅ `Home.jsx` split into 3+ components  
- ✅ React performance issues fixed (no infinite renders)
- ✅ Real pagination working with backend API
- ✅ Professional loading/error states

### 📦 Deliverables:

1. **📤 GitHub repo** with:
   - All optimized source code
   - Updated README with your changes
   - Performance improvements documented
   - Before/after API response time comparisons

2. **📹 Optional**: 2-minute demo video showing improvements

**⏰ Deadline**: Push within 5 hours of starting

---

## 📊 Scoring Rubric

| Area | Weight | Focus |
|------|--------|-------|
| 💻 **Code Quality** | 30% | Clean, readable, well-structured code |
| ⚡ **Performance** | 25% | Fixed pagination, optimized queries, React performance |
| 🏗️ **Architecture** | 20% | Component separation, API structure |
| ✅ **Functionality** | 15% | Working pagination, search, error handling |
| ✨ **UX Polish** | 10% | Smooth interactions, loading states |

**Passing score**: ≥ 70/100

---

## 🛠️ Development Tips

- 🎯 **Start with pagination** - biggest performance win
- 🔍 **Fix React re-renders** - check that `useEffect` dependency array
- 📊 **Measure performance** - use browser DevTools Network tab
- 🧪 **Test edge cases** - empty search results, API errors
- 📱 **Mobile-first** - Tailwind CSS is already configured

### 🔍 **Debugging Current Issues:**

```bash
# Check current API response size
curl -s http://localhost:8080/api/players | jq '.players | length'
# Should return: 100 (⚠️ too many!)

# Check for performance warning
curl -s http://localhost:8080/api/players | jq '.warning'  
# Should return: "⚠️ All players loaded at once - no pagination!"
```

---

## 🧹 Cleanup When Done

```bash
# Remove everything
docker compose down -v
docker system prune -af
```

---

## 🚀 Ready to Start?

1. `docker compose up -d` 
2. Identify the performance issues
3. Fix pagination + React problems
4. Push optimized code to GitHub
5. Document your improvements

**Good luck - show us your optimization skills! 💪**
