function runCounterInView() {
  const counterSection = document.querySelector('.block-counter');
  const counterItems = counterSection.querySelectorAll('[data-counter]');
  const counters = [...counterItems].map((item) => {
    const value = item.dataset.counter;
    if (value) {
      return new countUp.CountUp(item, Number(value));
    }
  });

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.intersectionRatio > 0) {
        // Add 'active' class if observation target is inside viewport
        entry.target.classList.add("active");

        counters.forEach((c) => {
          if (!c.error) {
            c.start();
          } else {
            console.error(c.error);
          }
        });

      } else {
        // Remove 'active' class otherwise
        entry.target.classList.remove("active");
      }
    });
  });

  observer.observe(counterSection);
}

runCounterInView();
