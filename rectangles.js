"use strict";

class Rectangles extends GridGame {

	reset() {
		super.reset();

		this.neighbors = [
			new Coords2D(0, -1),
			new Coords2D(1, 0),
			new Coords2D(0, 1),
			new Coords2D(-1, 0),
		];

		this.size = 0;
		this.checker = 0;
		this.colors = [];
		this.editable = false;
	}

	handleCellDragStart(start) {
		// ...
	}

	handleCellDragMove(start, end) {
		// ...
	}

	handleCellDragEnd(start, end) {
		if (start == end) {
			start.data('color', null);
			start = end = null;
			return;
		}

		var [x1, x2] = [start.cellIndex, end.cellIndex];
		x1 > x2 && ([x1, x2] = [x2, x1]);
		var [y1, y2] = [start.parentNode.rowIndex, end.parentNode.rowIndex];
		y1 > y2 && ([y1, y2] = [y2, y1]);

		const color = this.registerNewColor();
		const grid = start.parentNode.parentNode;
		for ( let y = y1; y <= y2; y++ ) {
			for ( let x = x1; x <= x2; x++ ) {
				grid.rows[y].cells[x].data('color', color);
			}
		}

		clearTimeout(this.checker);
		this.checker = setTimeout(() => this.winOrLose(), 500);
	}

	registerNewColor() {
		this.colors.push('#' + ('000000' + (Math.random()*0xFFFFFF<<0).toString(16)).slice(-6));
		$('#colors').setText(this.colors.map((color, i) => {
			return `td[data-color="${i}"] { background-color: ${color}; }`;
		}).join("\n"));
		return this.colors.length - 1;
	}

	getScore() {
		return {
			...super.getScore(),
			level: this.size,
		};
	}

	haveWon() {
		if (this.m_objGrid.getElements('td:not([data-color]').length) {
			return false;
		}

		const isGoalCell = td => td.textContent != '';

		const colors = this.m_objGrid.getElements('td[data-color]').map(td => td.data('color')).unique();
		const errors = colors.map(color => {
			const cells = this.m_objGrid.getElements(`td[data-color="${color}"]`);
			const colorCells = cells.filter(isGoalCell);
			if (colorCells.length != 1) return 1;

			const tl = cells.first();
			const br = cells.last();
			const A = (br.cellIndex - tl.cellIndex + 1) * (br.parentNode.rowIndex - tl.parentNode.rowIndex + 1);
			if (A != parseInt(colorCells[0].textContent)) return 2;
			if (A != cells.length) return 3;

			return 0;
		});

		const goals = this.m_objGrid.getElements('td').filter(isGoalCell);
		if (errors.join('') === '0'.repeat(goals.length)) {
			return true;
		}

		return false;
	}

	createFromExport(chars) {
		console.time('createFromExport');

		const size = Math.sqrt(chars.length);
		if (chars.length && size == parseInt(size)) {
			this.printGrid(this.createEmptyGrid(size));
			this.m_objGrid.getElements('td').forEach((el, i) => {
				el.textContent = chars[i] == '_' ? '' : (chars[i].charCodeAt(0) - 96);
			});
			console.timeEnd('createFromExport');
			return true;
		}
	}

	createEmptyGrid(size) {
		return (new Array(size)).fill(0).map(row => (new Array(size)).fill(-1));
	}

	async createMap(size) {
		this.reset();

		this.size = size;

		console.time('createMap');
		const s = Date.now();

		var grid;
		while (!(grid = this._create())) {
			if (Date.now() - s > 15000) {
				throw new Error('QUITTING AFTER TRYING FOR 15 SECONDS');
			}
		}

		console.timeEnd('createMap');

		const playableGrid = this.hideCellsPlayable(grid);
		this.printGrid(playableGrid);

		return grid;
	}

	hideCellsPlayable(grid) {
		const coords = [];
		for ( let y = 0; y < grid.length; y++ ) {
			for ( let x = 0; x < grid[y].length; x++ ) {
				const [group, size] = grid[y][x];
				coords[group] || (coords[group] = []);
				coords[group].push(`${x}-${y}`);
			}
		}

		const shows = coords.map(coords => coords[parseInt(Math.random() * coords.length)]);

		return grid.map((cells, y) => cells.map((cell, x) => {
			return shows.includes(`${x}-${y}`) ? cell[1] : null;
		}));
	}

	_create() {
		const grid = this.createEmptyGrid(this.size);

		const sizes = {};
		var group = 0;
		var next;
		while (next = this._next(grid)) {
			let leftX = this._leftX(grid, next);
			let leftY = this._leftY(grid, next);

			let sizeX = this._length(leftX);
			if (sizeX === false) {
// console.log('impossible X');
				group = 0;
				this._restartGrid(grid);
				continue;
			}

			let sizeY = this._length(leftY, sizeX);
			if (sizeY === false) {
// console.log('impossible Y');
				group = 0;
				this._restartGrid(grid);
				continue;
			}

			sizes[sizeX * sizeY] || (sizes[sizeX * sizeY] = 0);
			sizes[sizeX * sizeY]++;

			let dir = sizeX > sizeY ? 'hor' : (sizeX < sizeY ? 'ver' : 'square');
			for (let y = 0; y < sizeY; y++) {
				for (let x = 0; x < sizeX; x++) {
					grid[y + next.y][x + next.x] = [group, sizeX * sizeY, dir];
				}
			}

			group++;
		}

		if (sizes[1] && sizes[1] > 0) {
			return;
		}

		if (!this._validate(grid)) {
			return;
		}

		return grid;
	}

	_validate(grid) {
		for ( let y = 0; y < grid.length; y++ ) {
			for ( let x = 0; x < grid[y].length; x++ ) {
				const [group, size, dir] = grid[y][x];
// console.log({group, size, dir});
				for ( let [nx, ny] of this._neighbors(grid, x, y) ) {
					const [ngroup, nsize, ndir] = grid[ny][nx];
// console.log({ngroup, nsize, ndir});
					if (ngroup != group && nsize == size && ndir == dir) {
// console.log('invalid');
						return false;
					}
				}
			}
		}

		return true;
	}

	_neighbors(grid, x, y) {
		const neighbors = [];
		for ( let d of this.neighbors ) {
			if (grid[y+d.y] && grid[y+d.y][x+d.x] != null) {
				neighbors.push([x+d.x, y+d.y]);
			}
		}

		return neighbors;
	}

	_restartGrid(grid) {
		grid.forEach(row => row.fill(-1));
	}

	_next(grid) {
		for ( let y = 0; y < grid.length; y++ ) {
			for ( let x = 0; x < grid[y].length; x++ ) {
				if (grid[y][x] == -1) {
					return new Coords2D(x, y);
				}
			}
		}
	}

	_leftX(grid, coord) {
		const cells = grid[coord.y].slice(coord.x);
		return this._left(cells);
	}

	_leftY(grid, coord) {
		const cells = grid.map(row => row[coord.x]).slice(coord.y);
		return this._left(cells);
	}

	_left(cells) {
		const unset = cells.findIndex(val => val != -1);
		return unset == -1 ? cells.length : unset;
	}

	_length(max, other = 0) {
		if (other == 1 && max == 1) {
			return false;
		}

		const min = other == 1 && max > 1 ? 2 : 1;
		const length = this._rand(min, Math.min(5, max));

		if (other * length <= 12) {
			return length;
		}

		return this._length(max, other);
	}

	_rand(min, max) {
		return min + parseInt(Math.random() * (max+1-min));
	}

	debugGrid(grid) {
		console.log(grid.map(row => row.map(val => val === null ? '_' : Number(val)).join(' ')).join("\n"));
	}

	printGrid(grid) {
		this.m_objGrid.setHTML(this.createMapHtml(grid));
	}

	createMapHtml(grid) {
		var html = '';
		html += '<table>';
		for ( let y = 0; y < grid.length; y++ ) {
			html += '<tr>';
			for ( let x = 0; x < grid[y].length; x++ ) {
				const cell = grid[y][x];
				html += `<td>${cell != null && cell != -1 ? cell : ''}</td>`;
			}
			html += '</tr>';
		}
		html += '</table>';

		return html;
	}

	_groupColor(group) {
		this.colors || (this.colors = []);
		this.colors[group] || (this.colors[group] = '#' + ('000000' + (Math.random()*0xFFFFFF<<0).toString(16)).slice(-6));
		return this.colors[group];
	}

	listenCellDrag() {
		var draggingStart = null;
		var draggingEnd = null;

		this.m_objGrid.on(['mousedown', 'touchstart'], e => {
			if (e.rightClick) return;

			e.preventDefault();

			draggingStart = e.target;
			this.handleCellDragStart(draggingStart);
		});
		this.m_objGrid.on(['mousemove', 'touchmove'], e => {
			if (!draggingStart) return;

			e.preventDefault();

			draggingEnd = document.elementFromPoint(e.pageX, e.pageY);
			this.handleCellDragMove(draggingStart, draggingEnd);
		});
		this.m_objGrid.on(['mouseup', 'touchend'], e => {
			if (!draggingStart) return;

			e.preventDefault();

			draggingEnd || (draggingEnd = e.target);
			this.handleCellDragEnd(draggingStart, draggingEnd);
		});

		document.on(['mouseup', 'touchend'], function(e) {
			draggingStart = draggingEnd = null;
		});
	}

	listenControls() {
		this.listenCellDrag();

		$('#restart').on('click', e => {
			this.colors.length = 0;
			this.m_objGrid.getElements('td').data('color', null);
		});

		$('#newgame').on('click', e => {
			const size = this.m_objGrid.getElements('tr').length;
			requestIdleCallback(() => this.createMap(size));
		});

		$('#edit').on('click', e => {
			this.toggleEditable();
		});

		$('#export').on('click', e => {
			location.hash = this.exportCurrent();
		});
	}

	toggleEditable() {
		this.m_objGrid.getElements('td').data('color', null);

		if (this.editable = !this.editable) {
			this.m_objGrid.getElements('td').attr('contenteditable', '').setText('')[0].focus();
		}
		else {
			this.m_objGrid.getElements('td').attr('contenteditable', null);
			console.log(RectanglesSolver.fromDom($('table')));
		}
	}

	exportCurrent() {
		return this.m_objGrid.getElements('td').map(td => {
			return td.textContent ? String.fromCharCode(96 + parseInt(td.textContent)) : '_';
		}).join('');
	}

	createStats() {
	}

	setTime(time) {
	}

	setMoves(moves) {
	}

}

class RectanglesSolver {

	static fromDom(table) {
		try {
			const grid = table.getElements('tr').map(tr => {
				return tr.getElements('td').map(td => this.domToValue(td));
			});
			return new this(grid);
		}
		catch (ex) {
			return {};
		}
	}

	static domToValue(td) {
		if ( td.data('color') ) {
			return -1;
		}

		const value = td.textContent;
		if ( value ) {
			return parseInt(value);
		}

		return 0;
	}

	constructor(grid) {
		this.grid = grid;
		this.starts = this.makeStarts();
		this.shapes = this.makeShapes();
		this.possibles = this.makeAllPossibles();
	}

	makeStarts() {
		const coords = [];
		for ( let y = 0; y < this.grid.length; y++ ) {
			for ( let x = 0; x < this.grid[0].length; x++ ) {
				const A = this.grid[y][x];
				if ( A > 0 ) {
					coords.push(new Coords2D(x, y));
				}
			}
		}

		return coords;
	}

	makeShapes() {
		const shapes = {};
		for ( let A = 2; A <= 12; A++ ) {
			shapes[A] = [];
			for ( let w = 1; w <= A; w++ ) {
				if ( A % w == 0 ) {
					shapes[A].push(new RectanglesSolverShape(w, A/w));
				}
			}
		}

		return shapes;
	}

	makeAllPossibles() {
		return this.starts.map(C => this.makePossiblesFor(C));
	}

	makePossiblesFor(C) {
		const A = this.grid[C.y][C.x];
		if (A == -1) return [];

		const possibles = [];
		this.shapes[A].forEach(shape => {
			const dx = shape.width;
			const dy = shape.height;
			for ( let y = C.y; y >= 0 && y > C.y - dy; y-- ) {
				for ( let x = C.x; x >= 0 && x > C.x - dx; x-- ) {
					if ( x + dx <= this.grid[0].length && y + dy <= this.grid.length ) {
						const start = new Coords2D(x, y);
						const area = new RectanglesSolverArea(start, shape);
						if ( this.freeArea(area, C) ) {
							possibles.push(area);
						}
					}
				}
			}
		});

		return possibles;
	}

	freeArea(area, forC) {
		const C = area.topleft;
		const shape = area.shape;

		for ( let y = C.y; y < C.y + shape.height; y++ ) {
			for ( let x = C.x; x < C.x + shape.width; x++ ) {
				const self = forC.x == x && forC.y == y;
				if ( this.grid[y][x] != 0 && !self ) {
					return false;
				}
			}
		}
		return true;
	}

}

class RectanglesSolverShape {

	constructor(width, height) {
		this.width = width;
		this.height = height;
	}

}

class RectanglesSolverArea {

	constructor(topleft, shape) {
		this.topleft = topleft;
		this.shape = shape;
	}

}