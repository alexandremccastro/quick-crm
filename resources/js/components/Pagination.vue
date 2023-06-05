<template>
  <div class="join my-3 flex justify-center" v-if="totalPages > 1">
    <button class="join-item btn" :disabled="currentPage <= 1" @click="changePage(currentPage - 1)">Prev</button>
    <button class="join-item btn" v-for="pageNumber in visiblePages" :key="pageNumber"
      :class="{ 'btn-active': pageNumber == currentPage }" @click="changePage(pageNumber)">{{ pageNumber }}</button>
    <button class="join-item btn" :disabled="currentPage >= totalPages" @click="changePage(currentPage + 1)">Next</button>
  </div>
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
  props: {
    currentPage: {
      type: Number,
      required: true
    },
    totalPages: {
      type: Number,
      required: true
    }
  },
  created() {
    console.log(this.currentPage)
  },
  computed: {
    visiblePages() {
      const maxVisiblePages = 10;
      const halfVisiblePages = Math.floor(maxVisiblePages / 2);
      let startPage = Math.max(1, this.currentPage - halfVisiblePages);
      let endPage = Math.min(this.totalPages, startPage + maxVisiblePages - 1);

      if (endPage - startPage < maxVisiblePages - 1) {
        startPage = Math.max(1, endPage - maxVisiblePages + 1);
      }

      return Array.from({ length: endPage - startPage + 1 }, (_, index) => startPage + index);
    }
  },
  methods: {
    changePage(pageNumber) {
      window.location.href = `/customers?page=${pageNumber}`
    }
  }
});
</script>
