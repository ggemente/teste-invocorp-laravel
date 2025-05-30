<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { defineProps, ref, onMounted } from 'vue';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';

const props = defineProps({
    book: Object,
    authors: Array,
});

const form = useForm({
    _method: 'PUT',
    title: props.book.title,
    description: props.book.description,
    publication_date: props.book.publication_date,
    author_id: props.book.author_id,
    cover_image: null,
});

const currentCoverImageUrl = ref(props.book.cover_image_path ? `/storage/${props.book.cover_image_path}` : null);
const newCoverPreviewUrl = ref(null);

const handleFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.cover_image = file;
        newCoverPreviewUrl.value = URL.createObjectURL(file);
    } else {
        form.cover_image = null;
        newCoverPreviewUrl.value = null;
    }
};

const submit = () => {
    form.post(route('books.update', props.book.id), {
        onSuccess: () => {
            if (form.cover_image && !form.errors.cover_image) {
                newCoverPreviewUrl.value = null;
            }
        },
        onFinish: () => {
            currentCoverImageUrl.value = props.book.cover_image_path ? `/storage/${props.book.cover_image_path}` : null;
            const fileInput = document.getElementById('cover_image');
            if (fileInput) fileInput.value = '';
            form.cover_image = null;
        }
    });
};

</script>

<template>
    <AppLayout :title="`Editar Livro: ${book.title}`">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">Editar Livro</h1>
            <Button variant="outline" asChild>
                <Link :href="route('books.index')">&larr; Voltar para a lista</Link>
            </Button>
        </div>

        <Card class="w-full max-w-2xl mx-auto">
            <CardHeader>
                <CardTitle>{{ book.title }}</CardTitle>
                <CardDescription>Atualize os detalhes do livro abaixo.</CardDescription>
            </CardHeader>
            <form @submit.prevent="submit">
                <CardContent class="space-y-6">
                    <div class="space-y-2">
                        <Label for="title">Título</Label>
                        <Input v-model="form.title" id="title" :class="{ 'border-destructive': form.errors.title }" />
                        <p v-if="form.errors.title" class="text-sm text-destructive">{{ form.errors.title }}</p>
                    </div>

                    <div class="space-y-2">
                        <Label for="description">Descrição</Label>
                        <Textarea v-model="form.description" id="description" rows="5" :class="{ 'border-destructive': form.errors.description }" />
                        <p v-if="form.errors.description" class="text-sm text-destructive">{{ form.errors.description }}</p>
                    </div>

                    <div class="space-y-2">
                        <Label for="cover_image">Nova Capa do Livro (opcional)</Label>
                        <Input type="file" @input="handleFileChange" id="cover_image" accept="image/jpeg,image/png,image/jpg" :class="{ 'border-destructive': form.errors.cover_image }" />
                        <p v-if="form.errors.cover_image" class="text-sm text-destructive">{{ form.errors.cover_image }}</p>
                        <div v-if="newCoverPreviewUrl" class="mt-2">
                            <p class="text-sm text-muted-foreground">Preview da nova capa:</p>
                            <img :src="newCoverPreviewUrl" alt="Preview nova capa" class="h-32 w-auto rounded shadow">
                        </div>
                        <div v-else-if="currentCoverImageUrl" class="mt-2">
                            <p class="text-sm text-muted-foreground">Capa atual:</p>
                            <img :src="currentCoverImageUrl" :alt="`Capa de ${book.title}`" class="h-32 w-auto rounded shadow">
                        </div>
                        <p v-else class="mt-2 text-sm text-muted-foreground">Nenhuma capa cadastrada.</p>
                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <Label for="publication_date">Data de Publicação</Label>
                            <Input type="date" v-model="form.publication_date" id="publication_date" :class="{ 'border-destructive': form.errors.publication_date }" />
                            <p v-if="form.errors.publication_date" class="text-sm text-destructive">{{ form.errors.publication_date }}</p>
                        </div>
                        <div class="space-y-2">
                            <Label for="author_id">Autor</Label>
                            <Select v-model="form.author_id" id="author_id" :class="{ 'border-destructive': form.errors.author_id }">
                                <SelectTrigger>
                                    <SelectValue placeholder="Selecione um autor" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem v-for="author in authors" :key="author.id" :value="author.id">
                                        {{ author.name }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                            <p v-if="form.errors.author_id" class="text-sm text-destructive">{{ form.errors.author_id }}</p>
                        </div>
                    </div>
                </CardContent>
                <CardFooter class="flex justify-end space-x-2">
                    <Button variant="outline" asChild type="button">
                        <Link :href="route('books.index')">Cancelar</Link>
                    </Button>
                    <Button type="submit" :disabled="form.processing" :class="{ 'opacity-75': form.processing }">
                        <span v-if="form.processing" class="animate-spin mr-2">⏳</span>
                        Atualizar Livro
                    </Button>
                </CardFooter>
            </form>
        </Card>
    </AppLayout>
</template>