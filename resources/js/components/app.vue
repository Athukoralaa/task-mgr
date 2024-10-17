<template>
  <div>
    <h1>Task Manager</h1>
    <button @click="showCreateModal">Create Task</button>

    <table v-if="tasks.length" class="task-table">
      <thead>
        <tr>
          <th>Title</th>
          <th>Description</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="task in tasks" :key="task.id">
          <td>{{ task.title }}</td>
          <td class="description-cell">{{ task.description }}</td>
          <td>
            {{ task.status }}
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" role="switch" :id="'flexSwitchCheckDefault' + task.id" :checked="task.status === 'completed'" @change="toggleTaskStatus(task)">
            </div>
          </td>
          <td>
            <button @click="showEditModal(task)" class="btn btn-primary">Edit</button>
            <button @click="showDeleteModal(task)" class="btn btn-secondary">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Pagination Controls -->
    <div v-if="page_data.last_page> 1" class="pagination-controls">
      <button @click="fetchTasks(page_data.current_page - 1)" :disabled="page_data.current_page === 1">Previous</button>
      <span>Page {{ page_data.current_page }} of {{ page_data.last_page }}</span>
      <button @click="fetchTasks(page_data.current_page + 1)" :disabled="page_data.current_page === page_data.last_page">Next</button>
    </div>

    <!-- Create Task Modal -->
    <modal v-if="isCreateModalVisible" @close="closeModal">
      <template v-slot:header>Create New Task</template>
      <template v-slot:body>
        <form @submit.prevent="createTask">
          <div class="form-group">
            <label for="task-title">Title</label>
            <input type="text" v-model="newTask.title" id="task-title" name="task-title" class="form-control" placeholder="Task Title" required>
          </div>
          <div class="form-group">
            <label for="task-description">Description</label>
            <textarea v-model="newTask.description" id="task-description" name="task-description" class="form-control" placeholder="Task Description" required></textarea>
          </div>
        </form>
      </template>
      <template v-slot:footer>
        <button type="submit" class="btn btn-primary" @click="createTask">Create</button>
        <button type="button" class="btn btn-secondary" @click="closeModal">Cancel</button>
      </template>
    </modal>

    <!-- Edit Task Modal -->
    <modal v-if="isEditModalVisible" @close="closeModal">
      <template v-slot:header>Edit Task</template>
      <template v-slot:body>
        <form @submit.prevent="updateTask">
          <div class="form-group">
            <label for="edit-task-title">Title</label>
            <input type="text" v-model="selectedTask.title" id="edit-task-title" name="edit-task-title" class="form-control" placeholder="Task Title" required>
          </div>
          <div class="form-group">
            <label for="edit-task-description">Description</label>
            <textarea v-model="selectedTask.description" id="edit-task-description" name="edit-task-description" class="form-control" placeholder="Task Description" required></textarea>
          </div>
          <div class="form-group">
            <label for="task-status">Status</label>
            <select v-model="newTask.status" id="task-status" name="task-status" class="form-control" required>
              <option value="pending">Pending</option>
              <option value="completed">Completed</option>
            </select>
          </div>
        </form>
      </template>
      <template v-slot:footer>
        <button type="submit" class="btn btn-primary" @click="updateTask">Update</button>
        <button type="button" class="btn btn-secondary" @click="closeModal">Cancel</button>
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
    fetchTasks(page = 1) {
      axios.get(`/tasks?page=${page}`).then(response => {
        console.log("Full response:", response); // Log the entire response
        if (response.data && response.data.data) {
          this.tasks = response.data.data; // Assuming paginated response
        } else {
          this.tasks = response.data; // Handle non-paginated response
        }
        console.log("tk", this.tasks); // Corrected reference to this.tasks
        console.log("last page", response.data.last_page);
        this.page_data = response.data;
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
        // Toggle task status
    toggleTaskStatus(task) {
      axios.patch(`/tasks/${task.id}/toggle-status`).then(response => {
        this.fetchTasks(this.tasks.current_page); // Refresh tasks after update
      }).catch(error => {
        console.error('Error toggling task status:', error);
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

<style scoped>
.task-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
  table-layout: fixed;
}

.description-cell {
  max-width: 350px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.task-table th, .task-table td {
  border: 1px solid #ddd;
  padding: 8px;
}

.task-table th {
  background-color: #f2f2f2;
  text-align: left;
}

.form-group {
  margin-bottom: 1rem;
}

.form-control {
  width: 100%;
  padding: 0.5rem;
  margin-top: 0.25rem;
  border: 1px solid #ced4da;
  border-radius: 0.25rem;
}

.btn {
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 0.25rem;
  cursor: pointer;
}

.btn-primary {
  background-color: #007bff;
  color: white;
}

.btn-secondary {
  background-color: #6c757d;
  color: white;
}

.btn + .btn {
  margin-left: 0.5rem;
}

.form-check-input {
  transform: scale(1.5); /* Scale up the switch */
  background-color: rgb(255, 255, 82); /* Change switch color when unchecked */
  border-color: yellow;
}

.form-check-input:checked {
  background-color: rgb(0, 191, 0); /* Change switch color when checked */
  border-color: green; /* Change border color when checked */
}

.pagination-controls {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
}

.pagination-controls button {
  margin: 0 10px;
}
</style>