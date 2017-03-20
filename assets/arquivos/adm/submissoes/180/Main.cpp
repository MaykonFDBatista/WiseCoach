#include<stdio.h>
#include<stdlib.h>

main() {

    int i, x, j;

    scanf("%d", &i);
    getchar();

    for(j=0; j<i;j++) {

        scanf("%i", &x);

        if(x%2 == 0) {

            printf("0\n");
        } else {

            printf("1\n");
        }
    }
}
