<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head,useForm,usePage} from '@inertiajs/vue3';
import toast from '@/Stores/toast';
import InputError from "@/Components/InputError.vue";
const props = defineProps({
    departments: Object,
    achievements:Object, 
    errors:Object,
    employee:Object
});

import {ref,reactive} from 'vue';

const employee_data = useForm({
    name:props.employee.name,
    email:props.employee.email,
    phone:props.employee.phone,
    address:props.employee.address,
    department:props.employee.department,
    achievement:[props.employee.achievement]
});
console.log(props.employee);
function addMoreachievement(){
    employee_data.achievement.push({
        achievement_id:'',
        achievement_date:'',
      })
}

function removeItem(itemIndex){
    employee_data.achievement.splice(itemIndex,1);
}

function addData(){
    employee.post(`/employee/store`,{
        preserveScroll:true,
        onSuccess: () => {
            toast.add({
                message: 'Employee Created!'
            });
        }
    })
}

</script>

<template>
    <Head title="employee" />

    <AuthenticatedLayout>
        <div class="min-h-screen max-w-screen bg-gradient-to-bl from-violet-300 to-sky-300 flex flex-col gap-2 p-10 items-center">
            <div class="w-3/4 p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <h4>Employee Create</h4>  
                <!-- component -->
                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
                <div class="-mx-3 md:flex mb-6">
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-first-name">
                        Name
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" id="grid-first-name" type="text" placeholder="" v-model="employee_data.name">
                    <InputError v-if="errors.name"
                        class="mt-2"
                        :message="errors.name"
                    />
                    </div>
                    <div class="md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-last-name">
                        Email
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4" id="grid-last-name" type="email" placeholder="" v-model="employee_data.email">
                    <InputError v-if="errors.email"
                        class="mt-2"
                        :message="errors.email"
                    />
                    </div>
                </div>
                <div class="-mx-3 md:flex mb-6">
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-first-name">
                        Phone
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" id="grid-first-name" type="number" placeholder=""  v-model="employee_data.phone">
                    <InputError v-if="errors.phone"
                        class="mt-2"
                        :message="errors.phone"
                    />
                    </div>
                    <div class="md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-last-name">
                        Adress
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4" id="grid-last-name" type="text" placeholder=""  v-model="employee_data.address">
                    <InputError v-if="errors.address"
                        class="mt-2"
                        :message="errors.address"
                    />
                    </div>
                </div>
         
                <div class="-mx-3 md:flex mb-6">
                    <div class="md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-state">
                        Department
                    </label>
                    <div class="relative">
                        <select class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded" id="grid-state"  v-model="employee_data.department">
                        <option :value="department.id" v-for="(department,index) in props.departments" :key="index">{{ department.name }}</option>
                        </select>
                    </div>
                    <InputError v-if="errors.department"
                        class="mt-2"
                        :message="errors.department"
                    />
                    </div>
                </div>
                <template v-for="(items,index) in employee_data.achievement" :key="index">   
                        <div class="-mx-3 md:flex mb-2">         
                            <div class="md:w-1/2 px-3">
                                                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-zip">
                                                    achievements
                                                </label>
                                                    <select class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded mb-3" id="grid-state"  v-model="items.achievement_id" required>
                                                        <option :value="achievement.id" v-for="(achievement,index) in props.achievements" :key="index">{{ achievement.name }}</option>
                                                    </select>
                            </div>                       
                            <div class="md:w-1/1 px-3">
                                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-zip">
                                Achievements Date
                            </label>
                                <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4" id="grid-last-name" type="date" placeholder=""  v-model="items.achievement_date" required>
                            </div>
                            <div class="md:w-1/1 mt-8">
                             <button v-if="index>0" @click="removeItem(index)" class="p-1" type="button" style="background-color: rgb(216, 11, 11);color:aliceblue">Delete</button>
                            </div>                   
                        </div>
                </template>
                <div class="md:w-1/1">
                    <button class="float-left mt-5 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" @click="addMoreachievement()">
                            Add achievement
                        </button>
                </div>
                <button @click="addData()" type="button" class="mt-10 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
