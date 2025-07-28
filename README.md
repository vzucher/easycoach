# EasyCoach · "Players & Sessions" Challenge 🚀
_Full-stack developer technical assessment_

---

## 📋 What You're Building

A **"Players & Sessions" module** for EasyCoach.Club - list players with pagination, search, and training load visualization.

**Time limit**: 5 hours ⏱️  
**Tech stack**: PHP 8.3 + CodeIgniter 4 + React 18 + Vite + MariaDB  

---

## 🗂️ Repository Structure

```
easycoach/
├── 🔧 docker-compose.yml       # Zero-install dev environment
├── 📊 seed/
│   ├── hello.db                # SQLite dataset (10k players, 40k sessions)  
│   └── migrate.sql             # Sample DDL to adapt
├── 🖥️ backend/                 # CodeIgniter 4 API
│   ├── app/
│   │   └── PlayerController.php # Your API endpoints go here
│   ├── public/
│   └── composer.json
├── 🎨 frontend/                # React 18 + Vite app
│   ├── src/
│   │   ├── components/         # Extract components here
│   │   └── Home.jsx           # 420 LOC monolith to refactor  
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

# Wait ~2 minutes for backend to install PHP extensions
# Then open:
open http://localhost:5173    # 🎨 React frontend
open http://localhost:8080    # 🔧 CodeIgniter API
```

**Services running:**
- 🎨 **Frontend**: http://localhost:5173 (React + Vite)
- 🔧 **Backend**: http://localhost:8080 (PHP + CodeIgniter)  
- 🗄️ **Database**: localhost:3306 (MariaDB, user: `root`, password: `root`)

### 2. Alternative: Local development

```bash
# Backend
brew install php composer
cd backend && composer install && php spark serve

# Frontend  
cd frontend && npm install && npm run dev
```

---

## 🔧 Backend Challenge (60% of score)

### Your Mission:
1. **📊 Database Migration**
   - Import `seed/hello.db` into MariaDB
   - Add primary keys + indexes for **≤50ms queries** on 10k rows

2. **🛠️ Build API Endpoints**
   | Method | Route | Description |
   |--------|-------|-------------|
   | `GET /api/players` | List players | Pagination, search by name, sort by created_at |
   | `GET /api/players/{id}` | Player details | + last 30 days stats (distance, speed, sessions) |
   | `GET /api/players/{id}/sessions` | Player sessions | Paginated, filter by date range |

3. **📈 Performance Proof**
   - Implement `bin/benchmark.php` 
   - Test `/api/players?page=1&perPage=50`
   - Report mean & 95th percentile latency

4. **🏗️ Clean Architecture**
   - Use CodeIgniter 4: Models, Repositories, Migrations, Seeders
   - PSR-12 coding standards
   - At least one PHPUnit test

---

## 🎨 Frontend Challenge (40% of score)

### Your Mission:
1. **♻️ Refactor the 420-line `Home.jsx`**
   - Break into reusable components:
     - `PlayerTable` 
     - `LoadChart`
     - `PaginationControls`
   - Switch from mock data to real API calls

2. **✨ UX Requirements**
   - ✅ Pagination OR infinite scroll
   - ⏳ Loading states  
   - ❌ Error handling
   - 📱 Responsive design
   - Use: MUI, Mantine, or Tailwind CSS

3. **🌟 Extra Credit**
   - 🔍 Debounced search (300ms delay)
   - 📊 Last 7 days distance spark-line chart

---

## 🎯 Success Criteria & Deliverables

### ✅ What Success Looks Like:

**Backend (60%)**:
- ✅ All 3 API endpoints working
- ✅ Database properly indexed (≤50ms queries)
- ✅ Performance benchmark results included
- ✅ Clean, tested code architecture

**Frontend (40%)**:
- ✅ `Home.jsx` split into 3+ components  
- ✅ Real API integration (no mock data)
- ✅ Smooth pagination/infinite scroll
- ✅ Professional loading/error states

### 📦 Deliverables:

1. **📤 GitHub repo** with:
   - All source code
   - Updated README with setup instructions
   - Database migration files
   - Benchmark results pasted in README

2. **📹 Optional**: 2-minute demo video

**⏰ Deadline**: Push within 5 hours of starting

---

## 📊 Scoring Rubric

| Area | Weight | Focus |
|------|--------|-------|
| 💻 **Code Quality** | 30% | Clean, readable, well-structured |
| ⚡ **Performance** | 20% | Fast queries, proper indexing |
| 🏗️ **Architecture** | 20% | Component separation, API design |
| ✅ **Testing & Docs** | 15% | Tests, clear documentation |
| ✨ **UX Polish** | 10% | Smooth interactions, error handling |
| 🌟 **Extra Credit** | 5% | Search, charts, bonus features |

**Passing score**: ≥ 70/100

---

## 🛠️ Development Tips

- 🎯 **Focus on working code** over perfect architecture
- 📚 **Document your decisions** and shortcuts
- 🧪 **Test your API endpoints** manually first
- 📱 **Mobile-first** responsive design
- ⚡ **Performance matters** - use proper indexes!

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
2. Code for 5 hours
3. Push to GitHub
4. Share the repo link

**Good luck - show us what you can build! 💪**
