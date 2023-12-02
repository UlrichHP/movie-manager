<template>
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">{{ actor.name }}</h5>
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">{{ new Date(actor.birthday).toLocaleDateString('fr-FR') + ' | ' + actor.nationality }}</small>
                <div class="btn-group">
                    <a :href="'/actors/' + actor.id " type="button" class="btn btn-sm btn-outline-secondary">Voir</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
    import { ActorType } from '../../types/ActorType';

    defineProps<{
        actor: ActorType
    }>()
</script>
