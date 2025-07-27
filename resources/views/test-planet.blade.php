<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Planet Map Test</title>
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        .planet { width: 32px; height: 32px; border-radius: 50%; background: #16e3ef; position: absolute; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: bold; }
    </style>
</head>
<body style="background:#222;">
<div 
    x-data="progressMap()" 
    x-init="init([0,20,40,60,80,100], 35)" 
    style="position: relative; width: 800px; height: 200px; background: #222; margin:40px auto;">
    <svg viewBox="0 0 800 200" style="position:absolute;top:0;left:0;width:100%;height:100%;">
        <path x-ref="orbitPath" d="M50,150 C200,20 600,20 750,150" fill="none" stroke="#fff" stroke-width="2"/>
    </svg>
    <template x-for="(points, idx) in milestones" :key="idx">
        <div class="planet" :style="planetStyle(idx)" x-text="points"></div>
    </template>
</div>

<script>
function progressMap() {
    return {
        milestones: [],
        points: 0,
        positions: [],
        activeIdx: 0,
        init(milestones, points) {
            this.milestones = milestones;
            this.points = points;
            this.positions = [];
            this.$nextTick(() => {
                const path = this.$refs.orbitPath;
                if (path) {
                    const max = this.milestones[this.milestones.length - 1];
                    const len = path.getTotalLength();
                    this.positions = this.milestones.map(point => {
                        const pct = max > 0 ? point / max : 0;
                        const svgPt = path.getPointAtLength(len * pct);
                        return { left: svgPt.x, top: svgPt.y };
                    });
                }
            });
        },
        planetStyle(idx) {
            if (!this.positions[idx]) return '';
            return `left:${this.positions[idx].left - 16}px;top:${this.positions[idx].top - 16}px;`;
        }
    }
}
</script>
</body>
</html>
