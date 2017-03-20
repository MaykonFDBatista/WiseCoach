#include<stdio.h>
#include<stdlib.h>
#include<string.h>

main() {

    int i, forca, j;
    char nome[500];

    scanf("%d", &i);
    getchar();

    for(j=0; j<i;j++) {

        scanf("%s %i", &nome, &forca);
        getchar();

        if(strcmp(nome, "Thor") == 0) {

            printf("Y\n");
        } else {

            printf("N\n");
        }
    }
}