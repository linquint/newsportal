<template>
    <div class="author-info">
        <div class="author-header">
            <div class="author-image-skeleton" />
            <div class="flex-col" style="justify-content: center;">
                <div class="author-name-skeleton" />
                
                <div class="author-other-skeleton">
                    <span>@</span>
                    <div />
                </div>

                <div class="author-other-skeleton">
                    <span>Author since </span>
                    <div />
                </div>
            </div>
        </div>
        <span style="text-align: left; margin: 1rem 0 0.25rem; display: block; font-weight: bold; font-size: 1.25em;">About me</span>
        <div class="author-about-skeleton" />
    </div>
</template>

<style>
.author-info {
    width: clamp(256px, 90%, 768px);
    display: flex;
    flex-direction: column;
    margin: 80px auto 1rem;
}

.author-header {
    display: flex;
    flex-direction: row;
    gap: 1rem;
}

.author-image-skeleton {
    border-radius: 8px;
    width: 5rem;
    height: 5rem;
    margin: auto 0;
    animation: pulse 1s infinite alternate linear;
}

.author-name-skeleton {
    height: calc(2rem + 3px);
    width: 10rem;
    border-radius: 8px;
    animation: pulse 1s infinite alternate linear;
}

.author-other-skeleton {
    font-size: 1rem;
    text-align: left;
    color: var(--text-color-light);
    display: flex;
    flex-direction: row;
}

.author-other-skeleton div {
    height: 1rem;
    width: 5rem;
    border-radius: 8px;
    margin: auto 0.25rem;
    animation: pulse 1s infinite alternate linear;
}

.author-about-skeleton {
    height: calc(1em * 4);
    border-radius: 8px;
    margin-bottom: 2rem;
    animation: pulse 1s infinite alternate linear;
}

@media (max-width: 1024px) {
    .author-image-skeleton {
        width: 4rem;
        height: 4rem;
    }
    .author-name-skeleton {
        height: 1.75rem;
    }
}
@media (max-width: 768px) {
    .author-image-skeleton {
        width: 3.5rem;
        height: 3.5rem;
    }
    .author-name-skeleton {
        height: 1.5rem;
    }
    .author-other-skeleton {
        font-size: 0.9rem;
    }
    .author-other-skeleton div {
        height: 0.9rem;
    }
}
@media (max-width: 512px) {
    .author-image-skeleton {
        width: 3rem;
        height: 3rem;
    }
    .author-name-skeleton {
        height: 1.25rem;
    }
    .author-other-skeleton {
        font-size: 0.75rem;
    }
    .author-other-skeleton div {
        height: 0.75rem;
    }
}
@media (max-width: 360px) {
    .author-image-skeleton {
        width: 2.25rem;
        height: 2.25rem;
    }
    .author-name-skeleton {
        height: 1rem;
    }
    .author-other-skeleton {
        font-size: 0.5rem;
    }
    .author-other-skeleton div {
        height: 0.5rem;
    }
}
</style>