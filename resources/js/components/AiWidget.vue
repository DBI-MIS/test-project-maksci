<script setup lang="ts">
import axios from 'axios'
import { ref, nextTick } from 'vue'

type Message = {
  role: 'user' | 'assistant'
  content: string
}

const isOpen = ref(false)
const messages = ref<Message[]>([])
const input = ref('')
const loading = ref(false)
const container = ref<HTMLElement | null>(null)

const scrollToBottom = async () => {
  await nextTick()
  container.value?.scrollTo({ top: container.value.scrollHeight, behavior: 'smooth' })
}

const toggleChat = () => {
  isOpen.value = !isOpen.value
  scrollToBottom()
}

const sendMessage = async () => {
  if (!input.value.trim()) return

  const userMessage = input.value
  messages.value.push({ role: 'user', content: userMessage })

  input.value = ''
  loading.value = true

  await scrollToBottom()

  try {
    const res = await axios.post('/api/chat', {
      message: userMessage,
    })

    messages.value.push({
      role: 'assistant',
      content: res.data.reply,
    })
  } catch (e) {
    messages.value.push({
      role: 'assistant',
      content: 'Error: Unable to get response',
    })
  }

  loading.value = false
  await scrollToBottom()
}
</script>

<template>
  <!-- Floating Button -->
  <button
    @click="toggleChat"
    class="fixed bottom-5 right-5 w-14 h-14 rounded-full bg-blue-600 text-white shadow-lg hover:bg-blue-700 flex items-center justify-center text-xl"
  >
    Oi
  </button>

  <!-- Chat Window -->
  <div
    v-if="isOpen"
    class="fixed bottom-20 right-5 w-[380px] h-100 flex flex-col border rounded-xl bg-gray-900 text-white shadow-2xl"
  >
    <!-- Header -->
    <div class="p-3 border-b border-gray-700 flex justify-between items-center">
      <span class="font-semibold">AI Delas Alas</span>
      <button @click="toggleChat" class="text-gray-400 hover:text-white">✕</button>
    </div>

    <!-- Messages -->
    <div ref="container" class="flex-1 overflow-y-auto p-4 space-y-3">
      <div
        v-for="(msg, i) in messages"
        :key="i"
        class="flex"
        :class="msg.role === 'user' ? 'justify-end' : 'justify-start'"
      >
        <div
          class="px-3 py-2 rounded-lg max-w-[75%] whitespace-pre-wrap"
          :class="msg.role === 'user' ? 'bg-blue-600' : 'bg-gray-700'"
        >
          {{ msg.content }}
        </div>
      </div>

      <div v-if="loading" class="text-gray-400 text-sm">
        AI is typing...
      </div>
    </div>

    <!-- Input -->
    <div class="p-3 border-t border-gray-700 flex gap-2">
      <input
        v-model="input"
        @keyup.enter="sendMessage"
        class="flex-1 px-3 py-2 rounded bg-gray-800 outline-none"
        placeholder="Ask something..."
      />

      <button
        @click="sendMessage"
        class="px-4 py-2 bg-blue-600 rounded hover:bg-blue-700"
      >
        Send
      </button>
    </div>
  </div>
</template>