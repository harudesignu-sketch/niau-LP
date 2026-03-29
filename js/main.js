/* ===================================
   NiauMen's Hair LP - Main JavaScript
   GSAP + ScrollTrigger Animations
   =================================== */

document.addEventListener("DOMContentLoaded", () => {
  // Register GSAP plugins
  gsap.registerPlugin(ScrollTrigger);

  // ===== HERO SLIDESHOW =====
  initSlideshow();

  // ===== HERO ENTRANCE ANIMATION =====
  initHeroAnimation();

  // ===== SCROLL ANIMATIONS =====
  initScrollAnimations();

  // ===== FAQ ACCORDION =====
  initFAQ();

  // ===== SMOOTH SCROLL (sidebar nav) =====
  initSmoothScroll();

  // ===== NUMBER COUNT-UP =====
  initCountUp();
});

/* ----- Slideshow ----- */
function initSlideshow() {
  const slides = document.querySelectorAll(".hero__slide");
  if (slides.length === 0) return;

  let current = 0;
  const interval = 4000;

  function nextSlide() {
    slides[current].classList.remove("active");
    current = (current + 1) % slides.length;
    slides[current].classList.add("active");
  }

  setInterval(nextSlide, interval);
}

/* ----- Hero Entrance Animation ----- */
function initHeroAnimation() {
  const tl = gsap.timeline({ defaults: { ease: "power3.out" } });

  // Logo fade in
  tl.from(".hero__logo-sp", {
    opacity: 0,
    y: -20,
    duration: 0.8,
    delay: 0.3,
  });

  // Catch copy - stagger each line
  tl.from(
    ".hero__catch-accent",
    {
      opacity: 0,
      x: -40,
      duration: 0.8,
    },
    "-=0.3"
  );

  tl.from(
    ".hero__catch-sub",
    {
      opacity: 0,
      y: 20,
      duration: 0.6,
    },
    "-=0.3"
  );

  tl.from(
    ".hero__catch-main",
    {
      opacity: 0,
      y: 20,
      duration: 0.8,
    },
    "-=0.2"
  );

  tl.from(
    ".hero__desc",
    {
      opacity: 0,
      y: 20,
      duration: 0.6,
    },
    "-=0.3"
  );

  // Bottom image - reveal from bottom
  tl.from(
    ".hero__image-bottom",
    {
      opacity: 0,
      y: 60,
      duration: 1,
    },
    "-=0.3"
  );
}

/* ----- Scroll-triggered Animations ----- */
function initScrollAnimations() {
  // Basic fade-up for all [data-animate] elements
  const animateElements = document.querySelectorAll("[data-animate]");

  animateElements.forEach((el, index) => {
    // Determine animation type based on parent section
    const section = el.closest(".section");
    let animProps = {
      opacity: 0,
      y: 40,
      duration: 0.8,
      ease: "power2.out",
    };

    // Special animations for specific sections
    if (el.closest(".worries")) {
      animProps = {
        opacity: 0,
        x: -30,
        duration: 0.6,
        ease: "power2.out",
      };
    } else if (el.closest(".reasons__grid")) {
      animProps = {
        opacity: 0,
        scale: 0.9,
        duration: 0.6,
        ease: "back.out(1.4)",
      };
    } else if (el.closest(".results__cards")) {
      animProps = {
        opacity: 0,
        y: 30,
        duration: 0.6,
        ease: "power2.out",
      };
    } else if (el.closest(".why-choose")) {
      animProps = {
        opacity: 0,
        y: 50,
        duration: 0.9,
        ease: "power3.out",
      };
    } else if (el.closest(".before-after")) {
      animProps = {
        opacity: 0,
        y: 40,
        scale: 0.95,
        duration: 0.7,
        ease: "power2.out",
      };
    }

    gsap.from(el, {
      ...animProps,
      scrollTrigger: {
        trigger: el,
        start: "top 85%",
        end: "top 50%",
        toggleActions: "play none none none",
      },
    });

    // Reset the CSS initial state once GSAP takes over
    el.style.opacity = "";
    el.style.transform = "";
  });

  // Parallax effect on why-choose images
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

  // Results section - background parallax
  const resultsBg = document.querySelector(".results::before");
  if (document.querySelector(".results")) {
    gsap.to(".results", {
      backgroundPositionY: "30%",
      ease: "none",
      scrollTrigger: {
        trigger: ".results",
        start: "top bottom",
        end: "bottom top",
        scrub: 1,
      },
    });
  }

  // Stagger animations for grid items
  const reasonCards = document.querySelectorAll(".reasons__card");
  if (reasonCards.length > 0) {
    ScrollTrigger.create({
      trigger: ".reasons__grid",
      start: "top 80%",
      onEnter: () => {
        gsap.from(reasonCards, {
          opacity: 0,
          scale: 0.9,
          duration: 0.5,
          stagger: 0.15,
          ease: "back.out(1.4)",
        });
      },
      once: true,
    });
  }

  // Stagger animations for results cards
  const resultCards = document.querySelectorAll(".results__card");
  if (resultCards.length > 0) {
    ScrollTrigger.create({
      trigger: ".results__cards",
      start: "top 80%",
      onEnter: () => {
        gsap.from(resultCards, {
          opacity: 0,
          y: 30,
          duration: 0.5,
          stagger: 0.2,
          ease: "power2.out",
        });
      },
      once: true,
    });
  }

  // Before/After cards stagger
  const baCards = document.querySelectorAll(".before-after__card");
  if (baCards.length > 0) {
    ScrollTrigger.create({
      trigger: ".before-after__cards",
      start: "top 80%",
      onEnter: () => {
        gsap.from(baCards, {
          opacity: 0,
          y: 40,
          scale: 0.95,
          duration: 0.6,
          stagger: 0.2,
          ease: "power2.out",
        });
      },
      once: true,
    });
  }

  // Campaign section - special entrance
  const campaignBox = document.querySelector(".campaign__box");
  if (campaignBox) {
    gsap.from(campaignBox, {
      opacity: 0,
      scale: 0.9,
      duration: 1,
      ease: "power3.out",
      scrollTrigger: {
        trigger: campaignBox,
        start: "top 80%",
        toggleActions: "play none none none",
      },
    });

    // Pulse animation on CTA button
    gsap.to(".campaign__cta-btn", {
      scale: 1.05,
      duration: 0.8,
      ease: "power1.inOut",
      yoyo: true,
      repeat: -1,
      delay: 1,
    });
  }

  // Shop cards stagger
  const shopCards = document.querySelectorAll(".shops__card");
  if (shopCards.length > 0) {
    shopCards.forEach((card) => {
      gsap.from(card, {
        opacity: 0,
        y: 30,
        duration: 0.6,
        ease: "power2.out",
        scrollTrigger: {
          trigger: card,
          start: "top 85%",
          toggleActions: "play none none none",
        },
      });
    });
  }
}

/* ----- Count-up Animation ----- */
function initCountUp() {
  const numElements = document.querySelectorAll(".num-large");

  numElements.forEach((el) => {
    const target = parseFloat(el.textContent);
    if (isNaN(target)) return;

    const isDecimal = target % 1 !== 0;

    ScrollTrigger.create({
      trigger: el,
      start: "top 85%",
      onEnter: () => {
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
      },
      once: true,
    });
  });
}

/* ----- FAQ Accordion ----- */
function initFAQ() {
  const questions = document.querySelectorAll(".faq__question");

  questions.forEach((btn) => {
    btn.addEventListener("click", () => {
      const answer = btn.nextElementSibling;
      const toggle = btn.querySelector(".faq__toggle");
      const isOpen = answer.classList.contains("active");

      // Close all
      document.querySelectorAll(".faq__answer").forEach((a) => {
        a.classList.remove("active");
      });
      document.querySelectorAll(".faq__toggle").forEach((t) => {
        t.textContent = "＋";
      });
      document.querySelectorAll(".faq__question").forEach((q) => {
        q.setAttribute("aria-expanded", "false");
      });

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
      const targetId = anchor.getAttribute("href");
      const target = document.querySelector(targetId);

      if (target) {
        gsap.to(window, {
          duration: 0.8,
          scrollTo: {
            y: target,
            offsetY: 0,
          },
          ease: "power2.inOut",
        });
      }
    });
  });
}
