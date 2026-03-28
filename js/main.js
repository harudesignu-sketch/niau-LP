/* ============================================================
   NiauMen's Hair LP - Main JavaScript
   ============================================================ */

(function () {
  "use strict";

  // ---------- HEADER SCROLL ----------
  const header = document.getElementById("header");
  let lastScrollY = 0;

  function handleHeaderScroll() {
    const scrollY = window.scrollY;
    if (scrollY > 80) {
      header.classList.add("is-scrolled");
    } else {
      header.classList.remove("is-scrolled");
    }
    lastScrollY = scrollY;
  }

  window.addEventListener("scroll", handleHeaderScroll, { passive: true });

  // ---------- HAMBURGER MENU ----------
  const hamburger = document.getElementById("hamburger");
  const globalNav = document.getElementById("globalNav");

  if (hamburger && globalNav) {
    hamburger.addEventListener("click", function () {
      hamburger.classList.toggle("is-active");
      globalNav.classList.toggle("is-open");
      document.body.style.overflow = globalNav.classList.contains("is-open")
        ? "hidden"
        : "";
    });

    // Close on nav link click
    globalNav.querySelectorAll("a").forEach(function (link) {
      link.addEventListener("click", function () {
        hamburger.classList.remove("is-active");
        globalNav.classList.remove("is-open");
        document.body.style.overflow = "";
      });
    });
  }

  // ---------- SCROLL ANIMATIONS (Intersection Observer) ----------
  const animElements = document.querySelectorAll(
    ".anim-fade-up, .anim-slide-left, .anim-slide-right"
  );

  const observerOptions = {
    root: null,
    rootMargin: "0px 0px -80px 0px",
    threshold: 0.1,
  };

  const observer = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        const el = entry.target;
        const delay = parseFloat(el.dataset.delay) || 0;
        setTimeout(function () {
          el.classList.add("is-visible");
        }, delay * 1000);
        observer.unobserve(el);
      }
    });
  }, observerOptions);

  animElements.forEach(function (el) {
    observer.observe(el);
  });

  // ---------- COUNTER ANIMATION (Achievement Numbers) ----------
  function animateCounter(el, target, suffix) {
    const duration = 2000;
    const startTime = performance.now();
    const isFloat = target % 1 !== 0;

    function update(currentTime) {
      const elapsed = currentTime - startTime;
      const progress = Math.min(elapsed / duration, 1);
      // Ease out cubic
      const eased = 1 - Math.pow(1 - progress, 3);
      const current = eased * target;

      if (isFloat) {
        el.innerHTML = current.toFixed(1) + "<span>" + suffix + "</span>";
      } else {
        el.innerHTML =
          Math.floor(current) + "<span>" + suffix + "</span>";
      }

      if (progress < 1) {
        requestAnimationFrame(update);
      }
    }

    requestAnimationFrame(update);
  }

  const counterElements = document.querySelectorAll(".achievements__card-num");

  if (counterElements.length > 0) {
    const counterObserver = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            const el = entry.target;
            const text = el.textContent;
            const numMatch = text.match(/[\d.]+/);
            const suffixMatch = text.match(/[^\d.]+/);

            if (numMatch) {
              const target = parseFloat(numMatch[0]);
              const suffix = suffixMatch ? suffixMatch[0].trim() : "";
              animateCounter(el, target, suffix);
            }

            counterObserver.unobserve(el);
          }
        });
      },
      { threshold: 0.5 }
    );

    counterElements.forEach(function (el) {
      counterObserver.observe(el);
    });
  }

  // ---------- FAQ ACCORDION ----------
  const faqQuestions = document.querySelectorAll(".faq__question");

  faqQuestions.forEach(function (btn) {
    btn.addEventListener("click", function () {
      const isExpanded = btn.getAttribute("aria-expanded") === "true";
      const answer = btn.nextElementSibling;

      // Close all others
      faqQuestions.forEach(function (otherBtn) {
        if (otherBtn !== btn) {
          otherBtn.setAttribute("aria-expanded", "false");
          otherBtn.nextElementSibling.style.maxHeight = null;
        }
      });

      btn.setAttribute("aria-expanded", !isExpanded);

      if (!isExpanded) {
        answer.style.maxHeight = answer.scrollHeight + "px";
      } else {
        answer.style.maxHeight = null;
      }
    });
  });

  // ---------- FIXED CTA (Mobile) ----------
  const fixedCta = document.getElementById("fixedCta");
  const heroSection = document.getElementById("hero");

  if (fixedCta && heroSection) {
    const fixedCtaObserver = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (!entry.isIntersecting) {
            fixedCta.classList.add("is-visible");
          } else {
            fixedCta.classList.remove("is-visible");
          }
        });
      },
      { threshold: 0 }
    );

    fixedCtaObserver.observe(heroSection);
  }

  // ---------- SMOOTH SCROLL ----------
  document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
    anchor.addEventListener("click", function (e) {
      const targetId = this.getAttribute("href");
      if (targetId === "#") return;

      const target = document.querySelector(targetId);
      if (target) {
        e.preventDefault();
        const headerHeight = header.offsetHeight;
        const targetPosition =
          target.getBoundingClientRect().top + window.scrollY - headerHeight;

        window.scrollTo({
          top: targetPosition,
          behavior: "smooth",
        });
      }
    });
  });

  // ---------- HERO PARTICLES ----------
  const particlesContainer = document.getElementById("heroParticles");

  if (particlesContainer) {
    const canvas = document.createElement("canvas");
    const ctx = canvas.getContext("2d");
    particlesContainer.appendChild(canvas);

    canvas.style.width = "100%";
    canvas.style.height = "100%";
    canvas.style.position = "absolute";
    canvas.style.top = "0";
    canvas.style.left = "0";

    let particles = [];
    let animationId;

    function resizeCanvas() {
      canvas.width = particlesContainer.offsetWidth;
      canvas.height = particlesContainer.offsetHeight;
    }

    function createParticles() {
      particles = [];
      const count = Math.min(
        50,
        Math.floor((canvas.width * canvas.height) / 20000)
      );

      for (let i = 0; i < count; i++) {
        particles.push({
          x: Math.random() * canvas.width,
          y: Math.random() * canvas.height,
          size: Math.random() * 2 + 0.5,
          speedX: (Math.random() - 0.5) * 0.3,
          speedY: (Math.random() - 0.5) * 0.3,
          opacity: Math.random() * 0.3 + 0.1,
        });
      }
    }

    function drawParticles() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);

      particles.forEach(function (p) {
        p.x += p.speedX;
        p.y += p.speedY;

        if (p.x < 0) p.x = canvas.width;
        if (p.x > canvas.width) p.x = 0;
        if (p.y < 0) p.y = canvas.height;
        if (p.y > canvas.height) p.y = 0;

        ctx.beginPath();
        ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
        ctx.fillStyle =
          "rgba(200, 169, 110, " + p.opacity + ")";
        ctx.fill();
      });

      // Draw connections
      for (let i = 0; i < particles.length; i++) {
        for (let j = i + 1; j < particles.length; j++) {
          const dx = particles[i].x - particles[j].x;
          const dy = particles[i].y - particles[j].y;
          const dist = Math.sqrt(dx * dx + dy * dy);

          if (dist < 150) {
            ctx.beginPath();
            ctx.moveTo(particles[i].x, particles[i].y);
            ctx.lineTo(particles[j].x, particles[j].y);
            ctx.strokeStyle =
              "rgba(200, 169, 110, " +
              (0.05 * (1 - dist / 150)) +
              ")";
            ctx.lineWidth = 0.5;
            ctx.stroke();
          }
        }
      }

      animationId = requestAnimationFrame(drawParticles);
    }

    resizeCanvas();
    createParticles();
    drawParticles();

    window.addEventListener("resize", function () {
      resizeCanvas();
      createParticles();
    });

    // Pause particles when not visible
    const heroObserver = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            if (!animationId) drawParticles();
          } else {
            if (animationId) {
              cancelAnimationFrame(animationId);
              animationId = null;
            }
          }
        });
      },
      { threshold: 0 }
    );

    heroObserver.observe(heroSection);
  }

  // ---------- PARALLAX SUBTLE EFFECT ----------
  let ticking = false;

  window.addEventListener(
    "scroll",
    function () {
      if (!ticking) {
        requestAnimationFrame(function () {
          const scrollY = window.scrollY;
          const heroContent = document.querySelector(".hero__content");
          if (heroContent && scrollY < window.innerHeight) {
            heroContent.style.transform =
              "translateY(" + scrollY * 0.15 + "px)";
            heroContent.style.opacity = 1 - scrollY / (window.innerHeight * 0.8);
          }
          ticking = false;
        });
        ticking = true;
      }
    },
    { passive: true }
  );
})();
