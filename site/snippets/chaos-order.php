<div class="hidden lg:flex mx-auto w-min mt-[-5.5rem] mb-8">
  <button @click="order = !order" role="switch" class="group cursor-pointer relative" :aria-pressed="order" aria-label="Layout">
    <div class="flex items-center">
      <div class="flex gap-2 items-center rounded-sm p-2 text-secondary dark:text-brand">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden>
          <path fill-rule="evenodd" clip-rule="evenodd" d="M10 1H15V6H12V5H11H10V1ZM9 5V1V0H10H15H16V1V6V7H15H12V10H14H15V11V14V15H14H11H10V14V12H7V15V16H6H1H0V15V10V9H1H5V7H3H2V6V3V2H3H6H7V3V5H9ZM11 10V6H6V11H10V10H11ZM6 5V3H3V6H5V5H6ZM1 10V15H6V12H5V11V10H1ZM11 11H14V14H11V11Z" fill="currentColor" />
        </svg>
        <span>Chaos</span>
      </div>
      <div class="flex gap-2 items-center rounded-sm p-2 text-secondary dark:text-brand">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden>
          <path fill-rule="evenodd" clip-rule="evenodd" d="M1 1H6V6H1V1ZM0 0H1H6H7V1V6V7H6H1H0V6V1V0ZM10 1H15V6H10V1ZM9 0H10H15H16V1V6V7H15H10H9V6V1V0ZM15 10H10V15H15V10ZM10 9H9V10V15V16H10H15H16V15V10V9H15H10ZM1 10H6V15H1V10ZM0 9H1H6H7V10V15V16H6H1H0V15V10V9Z" fill="currentColor" />
        </svg>
        <span>Order</span>
      </div>
    </div>
    <div class="absolute bg-brand/[0.15] rounded-sm left-0 top-0 w-1/2 h-full group-aria-pressed:translate-x-full transition"></div>
  </button>
</div>