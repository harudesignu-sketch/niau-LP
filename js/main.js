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

  // ===== FALLBACK: ensure all elements become visible =====
  // If ScrollTrigger doesn't fire (e.g. missing images causing layout issues),
  // force-show all elements after 3 seconds
  setTimeout(() => {
    document.querySelectorAll("[data-animate]").forEach((el) => {
      const style = window.getComputedStyle(el);
      if (parseFloat(style.opacity) < 0.1) {
        gsap.to(el, { opacity: 1, y: 0, x: 0, scale: 1, duration: 0.5 });
      }
    });
  }, 3000);
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

  tl.from(".hero__logo-sp", {
    opacity: 0,
    y: -20,
    duration: 0.8,
    delay: 0.3,
  });

  tl.from(
    ".hero__catch-accent",
    { opacity: 0, x: -40, duration: 0.8 },
    "-=0.3"
  );

  tl.from(
    ".hero__catch-sub",
    { opacity: 0, y: 20, duration: 0.6 },
    "-=0.3"
  );

  tl.from(
    ".hero__catch-main",
    { opacity: 0, y: 20, duration: 0.8 },
    "-=0.2"
  );

  tl.from(
    ".hero__desc",
    { opacity: 0, y: 20, duration: 0.6 },
    "-=0.3"
  );

  tl.from(
    ".hero__image-bottom",
    { opacity: 0, y: 60, duration: 1 },
    "-=0.3"
  );
}

/* ----- Scroll-triggered Animations ----- */
function initScrollAnimations() {
  const animateElements = document.querySelectorAll("[data-animate]");

  animateElements.forEach((el) => {
    // Determine animation type based on parent section
    let fromProps = { opacity: 0, y: 40 };
    let duration = 0.8;
    let ease = "power2.out";

    if (el.closest(".worries")) {
      fromProps = { opacity: 0, x: -30 };
      duration = 0.6;
    } else if (el.closest(".reasons__grid")) {
      fromProps = { opacity: 0, scale: 0.9 };
      duration = 0.6;
      ease = "back.out(1.4)";
    } else if (el.closest(".results__cards")) {
      fromProps = { opacity: 0, y: 30 };
      duration = 0.6;
    } else if (el.closest(".why-choose")) {
      fromProps = { opacity: 0, y: 50 };
      duration = 0.9;
      ease = "power3.out";
    } else if (el.closest(".before-after")) {
      fromProps = { opacity: 0, y: 40, scale: 0.95 };
      duration = 0.7;
    }

    gsap.fromTo(
      el,
      fromProps,
      {
        opacity: 1,
        x: 0,
        y: 0,
        scale: 1,
        duration: duration,
        ease: ease,
        scrollTrigger: {
          trigger: el,
          start: "top 95%",
          toggleActions: "play none none none",
        },
      }
    );
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

  // Campaign section - special entrance
  const campaignBox = document.querySelector(".campaign__box");
  if (campaignBox) {
    gsap.fromTo(
      campaignBox,
      { opacity: 0, scale: 0.9 },
      {
        opacity: 1,
        scale: 1,
        duration: 1,
        ease: "power3.out",
        scrollTrigger: {
          trigger: campaignBox,
          start: "top 80%",
          toggleActions: "play none none none",
        },
      }
    );

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
          scrollTo: { y: target, offsetY: 0 },
          ease: "power2.inOut",
        });
      }
    });
  });
}
