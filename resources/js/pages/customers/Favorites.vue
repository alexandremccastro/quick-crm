<template>
  <div>
    <div class="flex mb-3 justify-between">
      <h1 class="text-lg">Favorites</h1>

      <div class="text-sm breadcrumbs">
        <ul>
          <li><a href="/home">Home</a></li>
          <li>Favorites</li>
        </ul>
      </div>

    </div>

    <div class="card rounded-lg bg-base-100">
      <Search action="/customers/favorites" />
      <table class="table  shadow-sm z-40">
        <thead>
          <tr>
            <th>Name</th>
            <th>CPF</th>
            <th>Phone</th>
            <th>Created At</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="parsedCustomers.length == 0">
            <td colspan="5">
              <div class="p-5 font-bold flex justify-center items-center text-center text-sm">
                <h1>Favorites list is empty!</h1>
              </div>
            </td>
          </tr>

          <ListItem v-for="customer in parsedCustomers" :customer="customer" />
        </tbody>
      </table>
    </div>

    <Pagination path="/customers/favorites" :currentPage="currentPage" :totalPages="totalPages" />
  </div>
</template>
<script>
import { defineComponent } from 'vue';
import ListItem from './List/ListItem.vue';
import Pagination from '@/components/Pagination.vue';
import Search from './Search.vue';

export default defineComponent({
  name: 'ListCustomers',
  props: ['pagination'],
  components: { ListItem, ListItem, Pagination, Search },

  data() {
    return {
      selectedCustomer: {}
    }
  },

  computed: {
    parsedPagination() {
      return JSON.parse(this.pagination)
    },
    parsedCustomers() {
      return this.parsedPagination?.records
    },
    currentPage() {
      return parseInt(this.parsedPagination?.currentPage)
    },
    totalPages() {
      return parseInt(this.parsedPagination?.totalPages)
    }
  }
})
</script>