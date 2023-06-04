<template>
  <div class="alert py-3" :class="classType">
    <template v-if="type == 'error'">
      <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current w-6 h-6" fill="none" viewBox="0 0 24 24"
        stroke-width="1.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
    </template>
    <template v-else-if="type == 'warning'">
      <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
      </svg>
    </template>
    <template v-else-if="type == 'success'">
      <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
    </template>
    <template v-else-if="type == 'info'">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-info shrink-0 w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
    </template>

    <span>{{ message }}</span>
  </div>
</template>
<script>
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'Alert',
  props: {
    type: {
      type: String,
      default: ''
    },
    message: {
      type: String,
      default: ''
    }
  },

  computed: {
    classType() {
      switch (this.type) {
        case 'error':
          return 'alert-error';
        case 'warning':
          return 'alert-warning';
        case 'success':
          return 'alert-success';
        case 'info':
          return 'alert-info';
        default:
          return '';
      }
    }
  }
})
</script>