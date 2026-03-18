<script setup lang="ts">
import { Form, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import TaskController from '@/actions/App/Http/Controllers/TaskController';
import TypeController from '@/actions/App/Http/Controllers/TypeController';
import Modal from '@/components/Modal.vue';
import AppLayout from '@/layouts/AppLayout.vue';




const props = defineProps({
    types: {
        type: Object,
        required: true
    },
   
});

const handleSuccess = () => {
    const popover = document.getElementById('addtype') as HTMLElement
    const popover3 = document.getElementById('edittype') as HTMLElement
    popover.hidePopover();
    popover3.hidePopover();
}

const deleteType = (id: number) => {
    if (confirm('Are you sure you want to delete Type?')) {
        router.delete(TypeController.destroy(id).url)

    }
}

const selectedType = ref();

const editType = (id: number) => {
    const type = props.types.find((type) =>
        type.id === id
    );

    selectedType.value = type;

}

</script>
<template>
    <AppLayout>

        <div class="flex flex-col bg-gray-50">
            <div class="bg-blue flex justify-between bg-slate-200 h-20 p-5 items-center">
                <Link :href="TaskController.dashboard().url">
                    <h1 class="text-3xl font-extrabold font-serif">To Do List</h1>
                </Link>
                <div class="flex gap-3">
                    <div class="bg-blue-300 w-30 h-10 rounded-2xl flex justify-center items-center">
                        <button popovertarget="addtask">
                            ADD Task
                        </button>
                    </div>
                    <div class="bg-blue-300 w-30 h-10 rounded-2xl flex justify-center items-center">
                        <button popovertarget="addtype">
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
            <div class="p-3">
                <table class="min-w-full border justify-center text-center shadow-xl">
                    <thead>
                        <tr class="border bg-mist-100 h-20">
                            <th>Type</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="typ in props.types" :key="typ.id" class="h-15">
                            <td class="p-5">{{ typ.type }}</td>
                            <td class="p-4">{{ typ.description }}</td>
                            <td class="p-4">
                                <div class="flex gap-4 justify-center">
                                    <button class="bg-blue-300 w-20 h-10 rounded-xl" @click="editType(typ.id)"  popovertarget="edittype">
                                        Edit
                                    </button>
                                    <button type="button" @click="deleteType(typ.id)"
                                        class="bg-red-500 w-20 h-10 rounded-xl">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Modal id="addtask">
                <Form v-bind="TaskController.store.form()">
                    <div class="flex flex-col items-center gap-5">
                        <label for="task" class="text-2xl">Add New Task</label>
                        <input type="text" name="task" class="border p-2 border-gray-300 h-10 w-50">
                        <select name="type_ids[]" id="" class="h-10 w-50 border border-gray-300">
                            <option value="">select type</option>
                            <option :value="t.id" v-for="t in props.types" :key="t.id">
                                {{ t.type }}
                            </option>
                        </select>
                        <input type="date" name="due" class="h-10 w-50 border border-gray-300 ">
                        <button type="submit" class="bg-blue-300 w-30 h-10 rounded-2xl">Submit</button>
                    </div>
                </Form>
            </Modal>
            <Modal id="addtype">
                <Form v-bind="TypeController.store.form()" reset-on-success @success="handleSuccess">
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
            <Modal id="edittype">
                <template v-if="selectedType">
                    <Form v-bind="TypeController.update.form(selectedType.id)" @success="handleSuccess">
                        <div class="flex flex-col items-center gap-5">
                            <label for="task" class="text-2xl">Type</label>
                            <input :defaultValue="selectedType.type" type="text" name="type"
                                class="border p-2 border-gray-300 h-10">
                            <label for="task" class="text-2xl">Description</label>
                            <input :defaultValue="selectedType.description" type="text" name="description"
                                class="border p-2 border-gray-300 h-10">
                            <button type="submit" class="bg-blue-300 w-30 h-10 rounded-2xl">Edit</button>
                        </div>
                    </Form>
                </template>
            </Modal>
        </div>
    </AppLayout>

</template>