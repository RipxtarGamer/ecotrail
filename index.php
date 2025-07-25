<?php include 'header.php'; ?>

<!-- Hero Section with Background Image -->
<style>
  .hero-section {
    background: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1470&q=80') no-repeat center center/cover;
    color: white;
    position: relative;
    min-height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .hero-overlay {
    background-color: rgba(0, 0, 0, 0.55);
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
  }

  .hero-content {
    position: relative;
    z-index: 2;
  }

  .hero-content h1 {
    font-weight: 800;
    font-size: 3rem;
  }

  @media (max-width: 768px) {
    .hero-content h1 {
      font-size: 2rem;
    }

    .hero-content p {
      font-size: 1rem;
    }
  }
</style>

<section class="hero-section text-center">
  <div class="hero-overlay"></div>
  <div class="container hero-content">
    <h1 class="display-4">Welcome to <span class="text-warning">EcoTrail+</span></h1>
    <p class="lead">Discover, plan, and explore Nepal's hidden gems with real-time trekking insights.</p>
    <div class="mt-4">
      <a href="/ecotrail/contribute/submit_alert.php" class="btn btn-light btn-lg me-2">🚨 Submit Alert</a>
      <a href="/ecotrail/community/new.php" class="btn btn-outline-light btn-lg">🌄 Share Hidden Gem</a>
    </div>
  </div>
</section>

<!-- Features Section -->
<section class="container py-5">
  <h2 class="text-center mb-5 fw-bold">🌟 What We Offer</h2>
  <div class="row text-center">
    <div class="col-md-4 mb-4">
      <div class="card h-100 shadow-sm border-0">
        <div class="card-body">
          <div class="mb-3 display-4 text-success">📡</div>
          <h5 class="card-title fw-bold">Live Trail Updates</h5>
          <p class="card-text">Stay informed with community-submitted alerts for route changes, closures.</p>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="card h-100 shadow-sm border-0">
        <div class="card-body">
          <div class="mb-3 display-4 text-warning">🧭</div>
          <h5 class="card-title fw-bold">Hidden Gem Submissions</h5>
          <p class="card-text">Explore hidden destinations shared by fellow trekkers and contribute your own discoveries in Community Forum.</p>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="card h-100 shadow-sm border-0">
        <div class="card-body">
          <div class="mb-3 display-4 text-primary">🗺️</div>
          <h5 class="card-title fw-bold">Trip Planner</h5>
          <p class="card-text">Easily plan treks with guidance on permits, guides, costs, and accommodation options.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="bg-light py-5">
  <div class="container text-center">
    <h3 class="fw-bold">👣 Be part of a safer, smarter trekking experience</h3>
    <p class="text-muted">Contribute, connect, and explore with the EcoTrail+ community.</p>
    <a href="/ecotrail/community" class="btn btn-outline-success btn-lg mt-3">💬 Join the Conversation</a>
  </div>
</section>

<?php include 'footer.php'; ?>
