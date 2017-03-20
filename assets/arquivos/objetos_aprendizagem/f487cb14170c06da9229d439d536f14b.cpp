#include<stdio.h>
#include<stdlib.h>


int distancia(int xi,int xt){
    return abs(xi-xt);
}

int main(){

    int i=0,n=0,dmin=0,t=0,xt=0,yt=0;
    int x[n],y[n];

    for(i=0;i<n;i++){
        scanf("%d %d",&x[i],&y[i]);
    }
    
    scanf("%d",&xt);
    
    for(i=0;i<n;i++){
        int d = distancia(x[i],xt);
        if(d < dmin){
            dmin = d;
            t = i;
        }
    }
    
    printf("%d",y[t]);
    
    return 0;
}
















