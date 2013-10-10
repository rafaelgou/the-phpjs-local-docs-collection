LIST=`ls *.markdown`
IMAGELIST=`cat imagelist.txt`
for list in $LIST
do
    for image in $IMAGELIST
    do
        sed -i "s/Insert ${image}.png/![figura ${image}](figures\/${image}-tn.png)/g" $list
#        sed -i "s/Insert \(.*\)?\.png/![figura](figure\1.png)/g" $list
    done
done

