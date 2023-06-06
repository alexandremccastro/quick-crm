<template>
  <div class="card h-32 text-gray-100 shadow-sm" :class="[color]">
    <div class="flex w-full h-full items-center justify-between p-5">
      <div class="self-center">
        <h1 class="text-4xl font-bold">{{ value }}</h1>
        <p>{{ label }}</p>
      </div>

      <div>
        <slot></slot>
      </div>
    </div>
  </div>
</template>
<script>
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'IconCard',
  props: ['label', 'value', 'color']
})
</script>