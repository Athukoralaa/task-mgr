<template>
  <div>
    <h1>Task Manager</h1>
    <button @click="showCreateModal">Create Task</button>

    
    <ul v-if="tasks.length">
      <li v-for="task in tasks" :key="task.id">
        <span>{{ task.title }} ({{ task.status }})</span>
        <button @click="showEditModal(task)">Edit</button>
        <button @click="showDeleteModal(task)">Delete</button>
      </li>
    </ul>

    <!-- Create Task Modal -->
    <modal v-if="isCreateModalVisible" @close="closeModal">
      <template v-slot:header>Create New Task</template>
      <template v-slot:body>
        <input type="text" v-model="newTask.title" id="task-title" name="task-title" placeholder="Task Title">
        <textarea v-model="newTask.description" id="task-description" name="task-description" placeholder="Task Description"></textarea>
      </template>
      <template v-slot:footer>
        <button @click="createTask">Create</button>
      </template>
    </modal>

    <!-- Edit Task Modal -->
    <modal v-if="isEditModalVisible" @close="closeModal">
      <template v-slot:header>Edit Task</template>
      <template v-slot:body>
        <input type="text" v-model="selectedTask.title" placeholder="Task Title">
        <textarea v-model="selectedTask.description" placeholder="Task Description"></textarea>
        <select v-model="selectedTask.status" id="task-status" name="task-status">
          <option value="pending">Pending</option>
          <option value="completed">Completed</option>
        </select>
      </template>
      <template v-slot:footer>
        <button @click="updateTask">Save Changes</button>
      </template>
    </modal>

    <!-- Delete Task Modal -->
    <modal v-if="isDeleteModalVisible" @close="closeModal">
      <template v-slot:header>Delete Task</template>
      <template v-slot:body>Are you sure you want to delete this task?</template>
      <template v-slot:footer>
        <button @click="deleteTask">Yes, Delete</button>
      </template>
    </modal>
  </div>
</template>

<script>
import axios from 'axios';
import Modal from './Modal.vue'; // Simple modal component



export default {
  components: {
    Modal
  },
  data() {
    return {
      tasks: [],
      isCreateModalVisible: false,
      isEditModalVisible: false,
      isDeleteModalVisible: false,
      newTask: {
        title: '',
        description: '',
        status: 'pending'
      },
      selectedTask: null
    };
  },
  methods: {
    // Fetch tasks from the backend
    fetchTasks() {
      axios.get('/tasks').then(response => {
        console.log("Full response:", response); // Log the entire response
        if (response.data && response.data.data) {
          this.tasks = response.data.data; // Assuming paginated response
        } else {
          this.tasks = response.data; // Handle non-paginated response
        }
        console.log("tk", this.tasks); // Corrected reference to this.tasks
      }).catch(error => {
        console.error('Error fetching tasks:', error);
      });
    },
    // Show the create task modal
    showCreateModal() {
      this.isCreateModalVisible = true;
    },
    // Show the edit task modal with pre-filled data
    showEditModal(task) {
      this.selectedTask = { ...task }; // Make a copy of the task
      this.isEditModalVisible = true;
    },
    // Show the delete confirmation modal
    showDeleteModal(task) {
      this.selectedTask = { ...task };
      this.isDeleteModalVisible = true;
    },
    // Create a new task
    createTask() {
      axios.post('/tasks', this.newTask).then(response => {
        this.tasks.push(response.data.task);
        this.closeModal();
      });
    },
    // Update the task
    updateTask() {
      axios.put(`/tasks/${this.selectedTask.id}`, this.selectedTask).then(response => {
        this.fetchTasks(); // Refresh tasks after update
        this.closeModal();
      });
    },
    // Delete the task
    deleteTask() {
      axios.delete(`/tasks/${this.selectedTask.id}`).then(() => {
        this.fetchTasks(); // Refresh tasks after deletion
        this.closeModal();
      });
    },
    // Close any open modal
    closeModal() {
      this.isCreateModalVisible = false;
      this.isEditModalVisible = false;
      this.isDeleteModalVisible = false;
    }
  },
  mounted() {
    this.fetchTasks(); // Fetch tasks when component is mounted
  }
};
</script>
