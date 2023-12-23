<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,Link,useForm} from '@inertiajs/vue3';
import {ref,reactive} from "vue";
import toast from '@/Stores/toast';
const props = defineProps({
    employees: {
        type: Object,
        default: () => ({}),
    },
});
const searchField = ["name","email","phone","address","department"];
const searchValue = ref();


const Header = [
    { text: "Name", value: "name" },
    { text: "Email", value: "email"},
    { text: "Phone", value: "phone"},
    { text: "Address", value: "address"},
    { text: "Department", value: "department"},
    { text: "Achievement", value: "achievement"},
    { text: "Action", value: "action"}
];
const form = useForm({
    'id': null,
});
function destroy(id){
    if (confirm("Are you sure you want to Delete")) {
        form.delete(`/employee/${id}`, {
        preserveScroll:true,
        onSuccess: () => {
            toast.remove({
                message: 'Employee successfully Deleted!'
            });
        }
       });
    }
}
</script>

<template>
    <Head title="employee" />

    <AuthenticatedLayout>
       
        <div class="min-h-screen max-w-screen bg-gradient-to-bl from-violet-300 to-sky-300 flex flex-col gap-2 p-10 items-center">
            <div class="w-3/4 p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
           <div class="relative overflow-x-auto shadow-md md:rounded-lg">
            <Link :href="route('employee.create')" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 float-right">Add Employee</Link>  
             <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <h2 class="mb-3">Product List</h2>
                <input placeholder="name/email/phone/address/department" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/4 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2" type="text" v-model="searchValue">
                <EasyDataTable buttons-pagination alternating :headers="Header" :items="employees" :rows-per-page="10" :search-field="searchField"  :search-value="searchValue" border-cell>
                    <template #item-action="employees">
                        <Link :href="route('employee.edit', employees.id)" class="text-white bg-gray-700  px-2 py-0.5 me-1 mr-2">
                            Edit
                        </Link>
                        <button  @click.prevent="destroy(employees.id)" title="Delete" type="submit" name="submit" value="Delete" class="text-white bg-red-700  px-2 py-0.5 me-1">
                            Delete
                        </button>
                    </template> 
                </EasyDataTable>
            </div>
        </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
