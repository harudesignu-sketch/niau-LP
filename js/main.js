/* ===================================
   NiauMen's Hair LP - Main JavaScript
   GSAP + ScrollTrigger Animations
   =================================== */

document.addEventListener("DOMContentLoaded", () => {
  gsap.registerPlugin(ScrollTrigger);

  initSlideshow();
  initHeroAnimation();
  initFAQ();
  initSmoothScroll();

  // Wait for images to load, then initialize scroll animations
  window.addEventListener("load", () => {
    initScrollAnimations();
    initCountUp();
    ScrollTrigger.refresh();
  });
});

/* ----- Slideshow ----- */
function initSlideshow() {
  const slides = document.querySelectorAll(".hero__slide");
  if (slides.length === 0) return;

  let current = 0;

  function nextSlide() {
    slides[current].classList.remove("active");
    current = (current + 1) % slides.length;
    slides[current].classList.add("active");
  }

  setInterval(nextSlide, 4000);
}

/* ----- Hero Entrance Animation ----- */
function initHeroAnimation() {
  const tl = gsap.timeline({ defaults: { ease: "power3.out" } });

  tl.from(".hero__logo-sp", {
    opacity: 0, y: -20, duration: 0.8, delay: 0.3,
  });
  tl.from(".hero__catch-accent", {
    opacity: 0, x: -40, duration: 0.8,
  }, "-=0.3");
  tl.from(".hero__catch-sub", {
    opacity: 0, y: 20, duration: 0.6,
  }, "-=0.3");
  tl.from(".hero__catch-main", {
    opacity: 0, y: 20, duration: 0.8,
  }, "-=0.2");
  tl.from(".hero__desc", {
    opacity: 0, y: 20, duration: 0.6,
  }, "-=0.3");
  tl.from(".hero__image-bottom", {
    opacity: 0, y: 60, duration: 1,
  }, "-=0.3");
}

/* ----- Scroll-triggered Animations ----- */
function initScrollAnimations() {
  // Use Intersection Observer as primary method (more reliable than ScrollTrigger for reveal)
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const el = entry.target;
          const delay = el.dataset.delay || 0;

          gsap.to(el, {
            opacity: 1,
            y: 0,
            x: 0,
            scale: 1,
            duration: 0.8,
            delay: parseFloat(delay),
            ease: "power2.out",
          });

          observer.unobserve(el);
        }
      });
    },
    { threshold: 0.05, rootMargin: "0px 0px 50px 0px" }
  );

  // Set initial hidden state and observe
  document.querySelectorAll("[data-animate]").forEach((el) => {
    // Determine initial state based on section
    if (el.closest(".worries")) {
      gsap.set(el, { opacity: 0, x: -30 });
    } else if (el.closest(".reasons__grid")) {
      gsap.set(el, { opacity: 0, scale: 0.9 });
    } else if (el.closest(".before-after")) {
      gsap.set(el, { opacity: 0, y: 40, scale: 0.95 });
    } else {
      gsap.set(el, { opacity: 0, y: 40 });
    }

    observer.observe(el);
  });

  // Stagger delays for grid items
  document.querySelectorAll(".reasons__card").forEach((card, i) => {
    card.dataset.delay = (i * 0.15).toString();
  });
  document.querySelectorAll(".results__card").forEach((card, i) => {
    card.dataset.delay = (i * 0.2).toString();
  });
  document.querySelectorAll(".before-after__card").forEach((card, i) => {
    card.dataset.delay = (i * 0.2).toString();
  });

  // Parallax effect on why-choose images (GSAP ScrollTrigger)
  document.querySelectorAll(".why-choose__image img").forEach((img) => {
    gsap.to(img, {
      yPercent: -15,
      ease: "none",
      scrollTrigger: {
        trigger: img.closest(".why-choose__item"),
        start: "top bottom",
        end: "bottom top",
        scrub: 1,
      },
    });
  });

  // Pulse animation on CTA button
  if (document.querySelector(".campaign__cta-btn")) {
    gsap.to(".campaign__cta-btn", {
      scale: 1.05,
      duration: 0.8,
      ease: "power1.inOut",
      yoyo: true,
      repeat: -1,
      delay: 1,
    });
  }

  // Fallback: force-show any still-hidden elements after 5 seconds
  setTimeout(() => {
    document.querySelectorAll("[data-animate]").forEach((el) => {
      const opacity = parseFloat(window.getComputedStyle(el).opacity);
      if (opacity < 0.5) {
        gsap.to(el, { opacity: 1, y: 0, x: 0, scale: 1, duration: 0.3 });
        observer.unobserve(el);
      }
    });
  }, 5000);
}

/* ----- Count-up Animation ----- */
function initCountUp() {
  const numElements = document.querySelectorAll(".num-large");

  numElements.forEach((el) => {
    const target = parseFloat(el.textContent);
    if (isNaN(target)) return;

    const isDecimal = target % 1 !== 0;

    const obs = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            const obj = { val: 0 };
            gsap.to(obj, {
              val: target,
              duration: 1.5,
              ease: "power2.out",
              onUpdate: () => {
                el.textContent = isDecimal
                  ? obj.val.toFixed(1)
                  : Math.round(obj.val);
              },
            });
            obs.unobserve(el);
          }
        });
      },
      { threshold: 0.5 }
    );

    obs.observe(el);
  });
}

/* ----- FAQ Accordion ----- */
function initFAQ() {
  document.querySelectorAll(".faq__question").forEach((btn) => {
    btn.addEventListener("click", () => {
      const answer = btn.nextElementSibling;
      const toggle = btn.querySelector(".faq__toggle");
      const isOpen = answer.classList.contains("active");

      // Close all
      document.querySelectorAll(".faq__answer").forEach((a) => a.classList.remove("active"));
      document.querySelectorAll(".faq__toggle").forEach((t) => (t.textContent = "＋"));
      document.querySelectorAll(".faq__question").forEach((q) => q.setAttribute("aria-expanded", "false"));

      // Toggle current
      if (!isOpen) {
        answer.classList.add("active");
        toggle.textContent = "−";
        btn.setAttribute("aria-expanded", "true");
      }
    });
  });
}

/* ----- Smooth Scroll ----- */
function initSmoothScroll() {
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", (e) => {
      e.preventDefault();
      const target = document.querySelector(anchor.getAttribute("href"));
      if (target) {
        target.scrollIntoView({ behavior: "smooth" });
      }
    });
  });
}
