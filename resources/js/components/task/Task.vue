<template>
    <div class="p-3 bg-blue-500 rounded-md">
        <transition
            enter-active-class="transition ease-in-out duration-300 transform"
            enter-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition ease-in-out duration-300 transform"
            leave-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
        >
            <div class="flex justify-end">
                <button
                    @click.prevent="showEditModal(task)"
                    class="px-2 py-1 mx-1 bg-yellow-400 text-white rounded-lg hover:bg-yellow-600 transition ease-in-out duration-300"
                >
                    <i class="fas fa-edit"></i>
                </button>
                <button
                    @click.prevent="showDeleteModal(task)"
                    class="px-2 py-1 mx-1 bg-red-500 text-white rounded-lg hover:bg-red-700 transition ease-in-out duration-300"
                >
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </transition>

        <p class="font-bold text-base text-white">
            {{ task.t_title }}
        </p>
        <p class="badge bg-indigo-600 border-none text-white mt-2">
            {{ task.t_description }}
        </p>
    </div>
</template>

<script>
export default {
    props: ["task"],
    methods: {
        showEditModal() {
            this.showModal("edit-task-modal");

            this.$emit("show-edit-modal", this.task);
        },
        showDeleteModal() {
            this.showModal("delete-task-modal");

            this.$emit("show-delete-modal", this.task);
        }
    }
};
</script>

<style></style>
