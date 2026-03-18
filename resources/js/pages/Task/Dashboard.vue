<script setup lang="ts">
import { Form, Link } from '@inertiajs/vue3'
import { computed, ref } from 'vue';

import TaskController from '@/actions/App/Http/Controllers/TaskController';
import TypeController from '@/actions/App/Http/Controllers/TypeController';
import Modal from '@/components/Modal.vue';
import AppLayout from '@/layouts/AppLayout.vue';


const props = defineProps({
    task: {
        type: Object,
        required: true
    },
    type: {
        type: Object,
        required: true
    }
});

const totalTasks = computed(() => props.task.length);

const totalPending = computed(() => props.task.filter(t => t.status === 'pending').length);
const totalCompleted = computed(() => props.task.filter(t => t.status === 'completed').length);

const completedTasks = computed(() =>
    props.task.filter((t: any) => t.status === 'completed').length
)


const progressPercent = computed(() => {

    if (totalTasks.value === 0) {
        return 0;
    }

    return Math.round((completedTasks.value / totalTasks.value) * 100);

});





</script>
<template>
    <AppLayout>
        <div class="flex flex-col bg-gray-50 ">
            <div class="bg-blue flex justify-between bg-slate-200 h-20 p-5 items-center ">
                <Link :href="TaskController.dashboard().url">
                    <h1 class="text-3xl font-extrabold font-serif">To Do List</h1>
                </Link>
                <div class="flex gap-3">
                    <div class="bg-blue-300 w-30 h-10 rounded-2xl flex justify-center items-center">
                        <!-- <Link :href="TaskController.create().url">
                            ADD Task
                        </Link> -->
                        <button popovertarget="createmodal">
                            ADD Task
                        </button>
                    </div>
                    <div class="bg-blue-300 w-30 h-10 rounded-2xl flex justify-center items-center">
                        <!-- <Link :href="TypeController.create().url">
                            ADD Type
                        </Link> -->
                        <button popovertarget="createdmodal">
                            ADD Type
                        </button>
                    </div>
                    <div class="bg-blue-300 w-30 h-10 rounded-2xl flex justify-center items-center">
                        <Link :href="TaskController.index().url">
                            Show Tasks
                        </Link>
                    </div>

                </div>
            </div>

            <div class="grid grid-cols-3 p-5 gap-3 font-mono ">
                <Link :href="TaskController.index().url">
                    <div
                        class="col-span-1 bg-blue-300 h-50 rounded-2xl p-3 flex text-white justify-center items-center shadow-xl text-center">
                        <h1 class="text-4xl font-extrabold">Total Task:</h1>
                        <p class="text-5xl flex justify-center items-center p-5">{{ props.task.length }}</p>
                    </div>
                </Link>
                <Link :href="TaskController.index().url">
                    <div
                        class="col-span-1 bg-orange-300 text-white h-50 rounded-2xl p-3 flex justify-center items-center shadow-xl text-center">
                        <h1 class="text-4xl font-extrabold">Pending:</h1>
                        <p class="text-5xl flex justify-center items-center p-5">{{ totalPending }}</p>
                    </div>
                </Link>
                <Link :href="TaskController.index().url">
                    <div
                        class="col-span-1 h-50 rounded-2xl p-3 flex justify-center items-center shadow-xl bg-green-400 text-white text-center">
                        <h1 class="text-4xl font-extrabold">Completed:</h1>
                        <p class="text-5xl flex justify-center items-center p-5">{{ totalCompleted }}</p>
                    </div>
                </Link>
                <div class="col-span-3 bg-mist-100 h-30 rounded-2xl p-4 shadow-xl">
                    <h1 class="text-2xl font-bold p-3">Progress</h1>
                    <div class="bg-gray-200 w-full h-6 rounded-full">
                        <div class="bg-green-500 h-6 rounded-full text-white text-sm flex items-center justify-center"
                            :style="{ width: progressPercent + '%' }">
                            {{ progressPercent }}%
                        </div>
                    </div>
                </div>

            </div>
            <Modal id="createmodal">
                <Form v-bind="TaskController.store.form()">
                    <div class="flex flex-col items-center gap-5">
                        <label for="task" class="text-2xl">Add New Task</label>
                        <input type="text" name="task" class="border p-2 border-gray-300 h-10 w-50">
                        <select name="type_ids[]" id="" class="h-10 w-50 border border-gray-300">
                            <option value="">select type</option>
                            <option :value="t.id" v-for="t in props.type" :key="t.id">
                                {{ t.type }}
                            </option>
                        </select>
                        <input type="date" name="due" class="h-10 w-50 border border-gray-300 ">
                        <button type="submit" class="bg-blue-300 w-30 h-10 rounded-2xl">Submit</button>
                    </div>
                </Form>
            </Modal>
            <Modal id="createdmodal">
                <Form v-bind="TypeController.store.form()">
                    <div class="flex flex-col items-center gap-5">
                        <label for="task" class="text-2xl">Create New Type</label>
                        <input type="text" name="type" class="border p-2 border-gray-300 h-10">
                        <label for="task" class="text-2xl">Description</label>
                        <input type="text" name="description" class="border p-2 border-gray-300 h-10">
                        <div class="flex gap-3">
                            <button type="submit" class="bg-blue-300 w-30 h-10 rounded-2xl">Submit</button>
                        </div>
                    </div>
                </Form>
            </Modal>
        </div>
    </AppLayout>
</template>