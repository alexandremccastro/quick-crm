<template>
  <div>
    <div class="flex mb-3 justify-between">
      <h1 class="text-lg">Customers</h1>
      <a href="/customers/create" class="btn btn-primary rounded-full btn-circle absolute bottom-10 right-10 z-50">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>

      </a>
    </div>

    <div class="card rounded-lg bg-base-100">
      <Search />
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
                <h1>Customer list is empty!</h1>
              </div>
            </td>
          </tr>

          <ListItem v-for="customer in parsedCustomers" :customer="customer" />
        </tbody>
      </table>

      <dialog id="deleteCustomerModal" class="modal">

        <form class="modal-box" method="POST" :action="`/customers/${selectedCustomer.id}`">
          <input type="hidden" name="method" value="DELETE" />
          <h3 class="font-bold text-lg">Delete customer</h3>
          <p class="py-4">If you proceed you can no longer recover the data.</p>

          <div class="modal-action gap-3">
            <!-- if there is a button, it will close the modal -->
            <button type="button" onclick="deleteCustomerModal.close()" class="btn ">Cancel</button>
            <button type="submit" class="btn btn-primary">Proceed</button>
          </div>
        </form>



        </dialog>
    </div>

    <Pagination :currentPage="currentPage" :totalPages="totalPages" />
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