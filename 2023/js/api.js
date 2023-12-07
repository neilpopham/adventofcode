class AdventofCodeLines {
  rows = null;

  constructor(rows) {
    this.rows = rows;
  }

  raw() {
    return this.rows;
  }

  regex(exp, slice = true) {
    const parsed = [];
    this.rows.forEach((row) => {
    	const match = row.match(exp)
      parsed.push(row.match(exp));
    });
    return parsed;
  }
}

class AdventOfCodeData {
  data = null;

  constructor(data) {
    this.data = data;
  }

  raw(trim = true) {
    return trim ? this.data.trim() : this.data;
  }

  lines(trim) {
    data = this.raw().replace("/\r*\n/", "\n");
    return new AdventofCodeLines(data.split("\n"));
  }
}

class AdventOfCode {
  YEAR = 2023;
  data_path = "data/{name}.txt";

  input(day) {
    const filename = this.calculatePath(day);
    console.debug(filename);
    data = fs.readFileSync(filename, "utf8");
    return new AdventOfCodeData(data);
  }

  example(day, index) {
    const filename = this.calculatePath(`${day}.${index}`);
    data = fs.readFileSync(filename, "utf8");
    return new AdventOfCodeData(data);
  }

  calculatePath(name) {
    name = this.data_path.replace("{name}", name);
    return path.join(__dirname, `../libs/${name}`);
  }
}
