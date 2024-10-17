<template>
  <div class="custom-modal-backdrop" @click.self="$emit('close')">
    <div class="custom-modal">
      <div class="custom-modal-header">
        <slot name="header"></slot>
        <button class="custom-close-btn" @click="$emit('close')">×</button>
      </div>
      <div class="custom-modal-body">
        <slot name="body"></slot>
      </div>
      <div class="custom-modal-footer">
        <slot name="footer"></slot>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Backdrop to darken the background, but keep modal visible */
.custom-modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000; /* Ensure it is above other elements */
}

/* Modal container */
.custom-modal {
  background: white;
  padding: 20px;
  border-radius: 8px;
  max-width: 600px;
  width: 100%;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  animation: fadeIn 0.3s ease-out;
}

/* Modal header */
.custom-modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid #e5e5e5;
  padding-bottom: 10px;
  margin-bottom: 20px;
}

/* Close button */
.custom-close-btn {
  background: none;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
  color: #aaa;
  transition: color 0.3s;
}

.custom-close-btn:hover {
  color: #000;
}

/* Modal body */
.custom-modal-body {
  padding-bottom: 20px;
}

/* Modal footer */
.custom-modal-footer {
  display: flex;
  justify-content: flex-end;
  border-top: 1px solid #e5e5e5;
  padding-top: 10px;
  margin-top: 20px;
}

/* Fade-in animation */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>